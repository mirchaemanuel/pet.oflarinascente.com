<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contact>
 */
class ContactFactory extends Factory
{
    protected $model = Contact::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isRead = fake()->boolean(20);
        $subjects = [
            'Informazioni sui servizi di cremazione',
            'Prenotazione servizio funebre per animale domestico',
            'Domande sulla tumulazione in giardino',
            'Richiesta di preventivo personalizzato',
            'Supporto nel momento del lutto',
            'Informazioni sulle urne artistiche',
            'Servizio di ritiro a domicilio',
            'Domande sulla conservazione delle ceneri',
        ];

        $italianPhonePrefixes = ['+39'];
        $phone = $italianPhonePrefixes[0].' '.fake()->numberBetween(200, 999).' '.fake()->numerify('## ## ##');

        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => $phone,
            'subject' => fake()->randomElement($subjects),
            'message' => fake()->paragraphs(2, true),
            'is_read' => $isRead,
            'read_at' => $isRead ? fake()->dateTimeBetween('-30 days', 'now') : null,
            'replied_at' => $isRead && fake()->boolean(50) ? fake()->dateTimeBetween('-30 days', 'now') : null,
            'notes' => fake()->optional(0.3)->sentence(),
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
        ];
    }

    /**
     * Indicate that the contact has been read.
     */
    public function read(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_read' => true,
            'read_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ]);
    }

    /**
     * Indicate that the contact is unread.
     */
    public function unread(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_read' => false,
            'read_at' => null,
            'replied_at' => null,
        ]);
    }

    /**
     * Indicate that the contact has been replied to.
     */
    public function replied(): static
    {
        return $this->read()->state(fn (array $attributes): array => [
            'replied_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ]);
    }
}
