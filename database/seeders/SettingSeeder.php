<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Generali
            [
                'key' => 'site_name',
                'value' => 'Onoranze Funebri La Rinascente - Pet Memorial',
                'group' => 'general',
                'type' => 'text',
                'description' => 'Nome del sito web',
            ],
            [
                'key' => 'site_description',
                'value' => 'Servizi funebri dedicati ai nostri amici a quattro zampe. Cremazione, sepoltura e memoriali con amore e rispetto.',
                'group' => 'general',
                'type' => 'textarea',
                'description' => 'Descrizione del sito',
            ],
            [
                'key' => 'site_tagline',
                'value' => 'Con amore e rispetto, per sempre nei nostri cuori',
                'group' => 'general',
                'type' => 'text',
                'description' => 'Slogan del sito',
            ],

            // Contatti
            [
                'key' => 'contact_email',
                'value' => 'info@oflarinascente.com',
                'group' => 'contact',
                'type' => 'email',
                'description' => 'Email principale per contatti',
            ],
            [
                'key' => 'contact_phone',
                'value' => '+39 333 123 4567',
                'group' => 'contact',
                'type' => 'tel',
                'description' => 'Numero di telefono principale',
            ],
            [
                'key' => 'contact_phone_secondary',
                'value' => '+39 333 765 4321',
                'group' => 'contact',
                'type' => 'tel',
                'description' => 'Numero di telefono secondario (opzionale)',
            ],
            [
                'key' => 'contact_whatsapp',
                'value' => '+39 333 123 4567',
                'group' => 'contact',
                'type' => 'tel',
                'description' => 'Numero WhatsApp',
            ],

            // Informazioni Aziendali
            [
                'key' => 'business_name',
                'value' => 'Onoranze Funebri La Rinascente S.r.l.',
                'group' => 'business',
                'type' => 'text',
                'description' => 'Ragione sociale',
            ],
            [
                'key' => 'business_address',
                'value' => 'Via Roma, 123',
                'group' => 'business',
                'type' => 'text',
                'description' => 'Indirizzo sede principale',
            ],
            [
                'key' => 'business_city',
                'value' => 'Milano',
                'group' => 'business',
                'type' => 'text',
                'description' => 'Città',
            ],
            [
                'key' => 'business_postal_code',
                'value' => '20100',
                'group' => 'business',
                'type' => 'text',
                'description' => 'CAP',
            ],
            [
                'key' => 'business_vat',
                'value' => 'IT12345678901',
                'group' => 'business',
                'type' => 'text',
                'description' => 'Partita IVA',
            ],
            [
                'key' => 'business_hours_weekdays',
                'value' => 'Lunedì - Venerdì: 9:00 - 18:00',
                'group' => 'business',
                'type' => 'text',
                'description' => 'Orari di apertura giorni feriali',
            ],
            [
                'key' => 'business_hours_saturday',
                'value' => 'Sabato: 9:00 - 13:00',
                'group' => 'business',
                'type' => 'text',
                'description' => 'Orari di apertura sabato',
            ],
            [
                'key' => 'business_hours_sunday',
                'value' => 'Domenica: Chiuso',
                'group' => 'business',
                'type' => 'text',
                'description' => 'Orari di apertura domenica',
            ],
            [
                'key' => 'business_emergency_available',
                'value' => '1',
                'group' => 'business',
                'type' => 'boolean',
                'description' => 'Disponibilità servizio emergenza 24/7',
            ],
            [
                'key' => 'business_emergency_phone',
                'value' => '+39 333 999 8888',
                'group' => 'business',
                'type' => 'tel',
                'description' => 'Numero emergenze (se disponibile)',
            ],

            // Social Media
            [
                'key' => 'social_facebook',
                'value' => 'https://facebook.com/oflarinascente',
                'group' => 'social',
                'type' => 'url',
                'description' => 'URL pagina Facebook',
            ],
            [
                'key' => 'social_instagram',
                'value' => 'https://instagram.com/oflarinascente',
                'group' => 'social',
                'type' => 'url',
                'description' => 'URL profilo Instagram',
            ],
            [
                'key' => 'social_twitter',
                'value' => '',
                'group' => 'social',
                'type' => 'url',
                'description' => 'URL profilo Twitter/X (opzionale)',
            ],

            // SEO
            [
                'key' => 'seo_meta_keywords',
                'value' => 'cremazione animali, sepoltura pet, memoriale cane, memoriale gatto, servizi funebri animali',
                'group' => 'seo',
                'type' => 'textarea',
                'description' => 'Parole chiave meta (separate da virgola)',
            ],
            [
                'key' => 'seo_google_analytics_id',
                'value' => '',
                'group' => 'seo',
                'type' => 'text',
                'description' => 'ID Google Analytics (es: G-XXXXXXXXXX)',
            ],
            [
                'key' => 'seo_google_site_verification',
                'value' => '',
                'group' => 'seo',
                'type' => 'text',
                'description' => 'Codice verifica Google Search Console',
            ],

            // Avanzate
            [
                'key' => 'advanced_memorial_moderation',
                'value' => '1',
                'group' => 'advanced',
                'type' => 'boolean',
                'description' => 'Richiedi moderazione per nuovi memoriali',
            ],
            [
                'key' => 'advanced_candle_duration_days',
                'value' => '7',
                'group' => 'advanced',
                'type' => 'number',
                'description' => 'Durata candela virtuale in giorni (0 = infinito)',
            ],
            [
                'key' => 'advanced_max_photos_per_memorial',
                'value' => '10',
                'group' => 'advanced',
                'type' => 'number',
                'description' => 'Numero massimo foto per memoriale',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
