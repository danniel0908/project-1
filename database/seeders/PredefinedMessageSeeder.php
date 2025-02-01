<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PredefinedMessage;

class PredefinedMessageSeeder extends Seeder
{
    public function run()
    {
        $messages = [
            [
                'title' => 'Application Approved',
                'content' => 'Your TODA application has been reviewed and APPROVED. You may now proceed to the TODA office for the release of your documents. Please bring valid ID and the application reference number.',
                'is_active' => true
            ],
            [
                'title' => 'Application Pending - Incomplete Documents',
                'content' => 'Your application is currently PENDING due to incomplete requirements. Please submit the following missing documents: [LIST MISSING DOCUMENTS]. Your application will be processed once all requirements are complete.',
                'is_active' => true
            ],
            [
                'title' => 'Application Denied',
                'content' => 'We regret to inform you that your TODA application has been DENIED. Reason: [SPECIFY REASON]. You may submit a new application after addressing the mentioned concerns.',
                'is_active' => true
            ],
            [
                'title' => 'Document Verification Required',
                'content' => 'Additional verification is required for your submitted documents. Please visit our office with the original copies of your documents for verification.',
                'is_active' => true
            ],
            [
                'title' => 'Schedule for Interview',
                'content' => 'Please be informed that you are scheduled for an interview on [DATE] at [TIME]. Kindly arrive 15 minutes before your scheduled time and bring all original documents.',
                'is_active' => true
            ],
            [
                'title' => 'Payment Required',
                'content' => 'Your application has been pre-approved. Please proceed with the payment of PHP [AMOUNT] at our cashier. Bring this notice and valid ID.',
                'is_active' => true
            ],
            [
                'title' => 'Application Under Review',
                'content' => 'Your application is currently under review. We will notify you of any updates or additional requirements needed. Thank you for your patience.',
                'is_active' => true
            ],
            [
                'title' => 'Follow-up Required',
                'content' => 'Please follow up on your application in person at our office. There are matters that need to be discussed regarding your application.',
                'is_active' => true
            ],
        ];

        foreach ($messages as $message) {
            PredefinedMessage::create($message);
        }
    }
}