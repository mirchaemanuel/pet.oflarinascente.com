<?php

declare(strict_types=1);

namespace App\Data;

readonly class ContactData
{
    public function __construct(
        public string $name,
        public string $email,
        public string $subject,
        public string $message,
        public ?string $phone = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function from(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            subject: $data['subject'],
            message: $data['message'],
            phone: $data['phone'] ?? null,
        );
    }
}
