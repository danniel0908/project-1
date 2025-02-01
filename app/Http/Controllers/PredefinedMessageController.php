<?php

namespace App\Http\Controllers;

use App\Models\PredefinedMessage;
use Illuminate\Http\Request;

class PredefinedMessageController extends Controller
{
    public function show($id)
    {
        try {
            $message = PredefinedMessage::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $message->id,
                    'title' => $message->title,
                    'content' => $message->content
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Message not found'
            ], 404);
        }
    }
}