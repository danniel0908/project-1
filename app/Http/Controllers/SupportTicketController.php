<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;


class SupportTicketController extends Controller
{

    private $drive;
    private $folder_id;

     // Define inquiry types and their corresponding roles
     private const INQUIRY_ROUTES = [
        'violation' => 'tmu',
        'technical' => 'admin',
        'account' => 'admin',
        'general' => 'admin'
    ];

    public function __construct()
    {
        $this->initGoogleDrive();
        $this->folder_id = config('services.google.support_ticket_folder'); // Make sure to add this to your config
    }

    private function initGoogleDrive()
    {
        $client = new Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->refreshToken(config('services.google.refresh_token'));
        
        $this->drive = new Drive($client);
    }

    // User Methods
    public function index()
    {
        $tickets = SupportTicket::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'inquiry_type' => 'required|in:' . implode(',', array_keys(self::INQUIRY_ROUTES)),
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120'
        ]);

        // Determine the assigned role based on inquiry type
        $assignedRole = $validatedData['inquiry_type'] === 'violation' ? 'tmu' : 'admin';

        $ticket = SupportTicket::create([
            'user_id' => Auth::id(),
            'subject' => $validatedData['subject'],
            'description' => $validatedData['description'],
            'priority' => $validatedData['priority'],
            'inquiry_type' => $validatedData['inquiry_type'],
            'assigned' => $assignedRole,
            'status' => 'open'
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $fileName = Auth::user()->name . '_' . $ticket->id . '_' . date('Y') . '_' . $file->getClientOriginalName();
                
                $fileMetadata = new DriveFile([
                    'name' => $fileName,
                    'parents' => [$this->folder_id]
                ]);

                $result = $this->drive->files->create($fileMetadata, [
                    'data' => file_get_contents($file->getRealPath()),
                    'mimeType' => $file->getMimeType(),
                    'uploadType' => 'multipart',
                    'fields' => 'id, webViewLink'
                ]);

                $ticket->attachments()->create([
                    'filename' => $fileName,
                    'path' => $result->id,
                    'drive_link' => $result->webViewLink,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize()
                ]);
            }
        }

        

        return redirect()->route('tickets.show', $ticket)
        ->with('success', 'Ticket created successfully');
    }

    public function show(SupportTicket $ticket)
    {
        // Check if user can view the ticket
        if (Gate::denies('view', $ticket)) {
            abort(403, 'Unauthorized access');
        }

        $messages = $ticket->messages()->with('user')->orderBy('created_at')->get();
        $attachments = $ticket->attachments; // Now contains Google Drive links


        return view('tickets.show', compact('ticket', 'messages', 'attachments'));
    }

    public function reply(Request $request, SupportTicket $ticket)
{
    $validatedData = $request->validate([
        'message' => 'required|string',
        'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120'
    ]);

    $message = $ticket->messages()->create([
        'user_id' => Auth::id(),
        'message' => $validatedData['message'],
        'is_admin_message' => Auth::user()->hasRole(['admin', 'tmu'])
    ]);

    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $file) {
            $fileName = Auth::user()->name . '_' . $ticket->id . '_' . date('Y') . '_' . $file->getClientOriginalName();
            
            $fileMetadata = new DriveFile([
                'name' => $fileName,
                'parents' => [$this->folder_id]
            ]);

            $result = $this->drive->files->create($fileMetadata, [
                'data' => file_get_contents($file->getRealPath()),
                'mimeType' => $file->getMimeType(),
                'uploadType' => 'multipart',
                'fields' => 'id, webViewLink'
            ]);

            $ticket->attachments()->create([
                'filename' => $fileName,
                'path' => $result->id,
                'drive_link' => $result->webViewLink,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize()
            ]);
        }
    }

    return redirect()->back()->with('success', 'Reply sent successfully');
}

    // Admin Methods
    public function adminIndex()
    {
        // Show only tickets assigned to the current admin's role
        $userRole = Auth::user()->role;
        
        $tickets = SupportTicket::with('user')
            ->when($userRole !== 'superadmin', function ($query) use ($userRole) {
                return $query->where('assigned', $userRole);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.tickets.index', compact('tickets'));
    }

    public function adminShow(SupportTicket $ticket)
{
    $user = auth()->user();
    
    // Check if user has admin access
    if (!in_array($user->role, ['admin', 'superadmin', 'tmu'])) {
        abort(403, 'Unauthorized access');
    }

    $messages = $ticket->messages()->with('user')->orderBy('created_at')->get();
    $attachments = $ticket->attachments; // Load the attachments

    return view('admin.tickets.show', compact('ticket', 'messages', 'attachments'));
}

    public function adminReply(Request $request, SupportTicket $ticket)
    {
        $user = auth()->user();
    
        // Check if user has admin access
        if (!in_array($user->role, ['admin', 'superadmin', 'tmu'])) {
            abort(403, 'Unauthorized access');
        }

        $validatedData = $request->validate([
            'message' => 'required|string',
            'status' => 'required|in:open,in_progress,resolved,closed'
        ]);

        // Create message with admin flag
        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $validatedData['message'],
            'is_admin_message' => true
        ]);

        // Update ticket status and last replied time
        $ticket->update([
            'status' => $validatedData['status'],
            'last_replied_at' => now()
        ]);

        return redirect()->route('admin.tickets.show', $ticket)
            ->with('success', 'Reply sent successfully');
    }

    
}