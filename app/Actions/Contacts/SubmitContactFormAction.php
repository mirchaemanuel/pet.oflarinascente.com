<?php

declare(strict_types=1);

namespace App\Actions\Contacts;

use App\Data\ContactData;
use App\Models\Contact;

class SubmitContactFormAction
{
    public function execute(ContactData $data, string $ipAddress, ?string $userAgent = null): Contact
    {
        return Contact::create([
            'name' => $data->name,
            'email' => $data->email,
            'phone' => $data->phone,
            'subject' => $data->subject,
            'message' => $data->message,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'is_read' => false,
        ]);
    }
}
