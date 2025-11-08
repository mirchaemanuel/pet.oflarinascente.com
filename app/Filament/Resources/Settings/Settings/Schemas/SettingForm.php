<?php

declare(strict_types=1);

namespace App\Filament\Resources\Settings\Settings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informazioni Impostazione')
                    ->description('Dati principali dell\'impostazione')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('key')
                                    ->label('Chiave')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->helperText('Identificatore univoco (es: site_name, contact_email)')
                                    ->regex('/^[a-z0-9_]+$/')
                                    ->validationMessages([
                                        'regex' => 'La chiave può contenere solo lettere minuscole, numeri e underscore',
                                    ])
                                    ->columnSpan(1),

                                Select::make('group')
                                    ->label('Gruppo')
                                    ->required()
                                    ->options([
                                        'general' => 'Generali',
                                        'contact' => 'Contatti',
                                        'business' => 'Informazioni Aziendali',
                                        'social' => 'Social Media',
                                        'seo' => 'SEO',
                                        'advanced' => 'Avanzate',
                                    ])
                                    ->default('general')
                                    ->helperText('Categoria dell\'impostazione')
                                    ->columnSpan(1),

                                Select::make('type')
                                    ->label('Tipo')
                                    ->required()
                                    ->options([
                                        'text' => 'Testo',
                                        'textarea' => 'Testo lungo',
                                        'number' => 'Numero',
                                        'boolean' => 'Sì/No',
                                        'email' => 'Email',
                                        'tel' => 'Telefono',
                                        'url' => 'URL',
                                    ])
                                    ->default('text')
                                    ->helperText('Tipo di dato dell\'impostazione')
                                    ->columnSpan(1),
                            ]),

                        Textarea::make('description')
                            ->label('Descrizione')
                            ->rows(2)
                            ->maxLength(500)
                            ->helperText('Descrizione dell\'impostazione (opzionale)')
                            ->columnSpanFull(),
                    ]),

                Section::make('Valore')
                    ->schema([
                        Textarea::make('value')
                            ->label('Valore')
                            ->rows(4)
                            ->maxLength(65535)
                            ->helperText('Il valore dell\'impostazione')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
