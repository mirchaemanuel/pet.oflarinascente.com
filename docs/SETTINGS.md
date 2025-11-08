# Sistema di Impostazioni

Il sistema di impostazioni permette di configurare l'applicazione attraverso un'interfaccia Filament e di esportare/importare le configurazioni tramite file YAML.

## Caratteristiche

- **Gestione tramite Admin Panel**: Interfaccia Filament per modificare le impostazioni
- **Caching Automatico**: Tutte le impostazioni sono cachate per migliori performance
- **Import/Export YAML**: Bootstrap delle impostazioni da file YAML (ideale per produzione)
- **Helper Functions**: Funzioni globali per accedere facilmente alle impostazioni
- **Organizzazione per Gruppi**: Le impostazioni sono organizzate in gruppi logici

## Gruppi di Impostazioni

Le impostazioni sono organizzate nei seguenti gruppi:

- **general**: Impostazioni generali del sito (nome, descrizione, tagline)
- **contact**: Informazioni di contatto (email, telefono, WhatsApp)
- **business**: Informazioni aziendali (ragione sociale, indirizzo, orari, P.IVA)
- **social**: Link ai social media (Facebook, Instagram, Twitter)
- **seo**: Impostazioni SEO (meta keywords, Google Analytics, Search Console)
- **advanced**: Impostazioni avanzate (moderazione, durata candele, limiti foto)

## Utilizzo nelle View (Blade Templates)

Utilizza le funzioni helper per accedere alle impostazioni:

```blade
{{-- Ottenere una singola impostazione --}}
<h1>{{ setting('site_name') }}</h1>
<p>{{ setting('site_description') }}</p>

{{-- Con valore di default --}}
<a href="mailto:{{ setting('contact_email', 'info@example.com') }}">
    Contattaci
</a>

{{-- Ottenere tutte le impostazioni di un gruppo --}}
@php
    $businessInfo = settings('business');
@endphp

<address>
    {{ $businessInfo['business_name'] }}<br>
    {{ $businessInfo['business_address'] }}<br>
    {{ $businessInfo['business_city'] }} {{ $businessInfo['business_postal_code'] }}
</address>

{{-- Ottenere tutte le impostazioni --}}
@php
    $allSettings = settings();
@endphp
```

## Utilizzo in PHP

```php
use App\Models\Setting;

// Ottenere una singola impostazione
$siteName = Setting::get('site_name');
$siteName = setting('site_name'); // Usando l'helper

// Con valore di default
$email = Setting::get('contact_email', 'default@example.com');
$email = setting('contact_email', 'default@example.com'); // Usando l'helper

// Impostare un valore
Setting::set('site_name', 'Nuovo Nome');

// Ottenere tutte le impostazioni raggruppate
$grouped = Setting::getAllGrouped();
// ['general' => [...], 'contact' => [...], ...]

// Pulire la cache
Setting::clearCache();
```

## Gestione tramite Admin Panel

1. Accedi al pannello di amministrazione: `/admin`
2. Naviga alla sezione **Impostazioni**
3. Crea, modifica o elimina impostazioni
4. Le modifiche saranno automaticamente cachate

## Bootstrap per Produzione

Per importare le impostazioni da file YAML (consigliato per produzione):

### 1. Preparare il file YAML

Modifica il file `config/settings.yaml` con le tue impostazioni:

```yaml
- key: site_name
  value: "Il Mio Sito"
  group: general
  type: text
  description: "Nome del sito web"

- key: contact_email
  value: "info@example.com"
  group: contact
  type: email
  description: "Email principale"
```

### 2. Eseguire il comando di bootstrap

```bash
# Bootstrap con file di default (config/settings.yaml)
php artisan settings:bootstrap

# Specificare un file diverso
php artisan settings:bootstrap --file=config/settings-production.yaml

# Forzare l'aggiornamento di impostazioni esistenti
php artisan settings:bootstrap --force

# Pulire la cache dopo il bootstrap
php artisan settings:bootstrap --clear-cache

# Combinare le opzioni
php artisan settings:bootstrap --force --clear-cache
```

### 3. Comportamento del comando

- **Senza `--force`**: Crea solo nuove impostazioni, salta quelle esistenti
- **Con `--force`**: Aggiorna anche le impostazioni esistenti
- **`--clear-cache`**: Pulisce la cache delle impostazioni dopo l'importazione

## Ambiente di Sviluppo

In ambiente di sviluppo, puoi utilizzare il seeder:

```bash
php artisan db:seed --class=SettingSeeder
```

**NOTA**: I seeder non devono MAI essere eseguiti in produzione. Per produzione, usa sempre il comando `settings:bootstrap`.

## Cache

Le impostazioni sono automaticamente cachate per migliorare le performance:

- La cache viene creata al primo accesso
- La cache viene pulita automaticamente quando un'impostazione viene modificata o eliminata
- Puoi pulire manualmente la cache con `Setting::clearCache()` o `php artisan settings:bootstrap --clear-cache`

## Testing

Esempio di test per verificare le impostazioni:

```php
use App\Models\Setting;

test('can get setting value', function () {
    Setting::create([
        'key' => 'test_setting',
        'value' => 'test value',
        'group' => 'general',
        'type' => 'text',
    ]);

    $value = setting('test_setting');
    expect($value)->toBe('test value');
});
```

## Tipi di Impostazione Supportati

- `text`: Testo breve
- `textarea`: Testo lungo
- `number`: Numero
- `boolean`: Valore booleano (1/0, true/false)
- `email`: Email
- `tel`: Numero di telefono
- `url`: URL

## Best Practices

1. **Usa helper functions nelle view**: Preferisci `setting('key')` a `Setting::get('key')`
2. **Organizza per gruppi**: Mantieni le impostazioni organizzate per facilità di gestione
3. **Fornisci valori di default**: Usa sempre un valore di default quando chiami `setting()`
4. **YAML per produzione**: Non usare mai i seeder in produzione, usa sempre il file YAML
5. **Versionamento**: Includi `config/settings.yaml` nel controllo versione
6. **Documentazione**: Aggiungi descrizioni chiare per ogni impostazione
7. **Validazione**: Usa il campo `type` per indicare il tipo di dato atteso

## Esempio Completo

### File YAML (`config/settings.yaml`)

```yaml
- key: site_name
  value: "Pet Memorial Services"
  group: general
  type: text
  description: "Nome del sito"

- key: contact_email
  value: "info@example.com"
  group: contact
  type: email
  description: "Email principale"
```

### View Blade

```blade
<!DOCTYPE html>
<html>
<head>
    <title>{{ setting('site_name', 'Default Site Name') }}</title>
</head>
<body>
    <h1>{{ setting('site_name') }}</h1>

    <footer>
        <a href="mailto:{{ setting('contact_email') }}">
            Contattaci
        </a>
    </footer>
</body>
</html>
```

### Deployment in Produzione

```bash
# 1. Deploy del codice
git pull

# 2. Installare dipendenze
composer install --no-dev --optimize-autoloader

# 3. Eseguire migrazioni
php artisan migrate --force

# 4. Bootstrap impostazioni
php artisan settings:bootstrap --force --clear-cache

# 5. Ottimizzare applicazione
php artisan optimize
```
