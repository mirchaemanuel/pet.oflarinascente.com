<?php

declare(strict_types=1);

namespace App\Filament\Resources\Bookings\Schemas;

use App\Enums\BookingStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Servizio')
                    ->schema([
                        Select::make('service_id')
                            ->label('Servizio')
                            ->relationship('service', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->helperText('Seleziona il servizio richiesto dal cliente'),
                    ]),

                Section::make('Informazioni Pet')
                    ->description('Dati del pet per cui si richiede il servizio')
                    ->schema([
                        TextInput::make('pet_name')
                            ->label('Nome Pet')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('pet_species')
                            ->label('Specie')
                            ->maxLength(255),

                        TextInput::make('pet_breed')
                            ->label('Razza')
                            ->maxLength(255),

                        TextInput::make('pet_weight_kg')
                            ->label('Peso (kg)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(200)
                            ->suffix('kg'),
                    ])
                    ->columns(4),

                Section::make('Informazioni Cliente')
                    ->description('Dati di contatto del cliente')
                    ->schema([
                        TextInput::make('customer_name')
                            ->label('Nome Cliente')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('customer_email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        TextInput::make('customer_phone')
                            ->label('Telefono')
                            ->tel()
                            ->required()
                            ->maxLength(255),

                        Textarea::make('customer_address')
                            ->label('Indirizzo')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Section::make('Data e Ora Preferita')
                    ->schema([
                        DatePicker::make('preferred_date')
                            ->label('Data Preferita')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->helperText('Data preferita per il servizio'),

                        TimePicker::make('preferred_time')
                            ->label('Ora Preferita')
                            ->native(false)
                            ->seconds(false)
                            ->helperText('Ora preferita per il servizio'),
                    ])
                    ->columns(2),

                Section::make('Messaggio e Richieste')
                    ->schema([
                        Textarea::make('message')
                            ->label('Messaggio')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Messaggio dal cliente'),

                        Textarea::make('special_requests')
                            ->label('Richieste Speciali')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Eventuali richieste particolari del cliente'),
                    ]),

                Section::make('Gestione Prenotazione')
                    ->schema([
                        Select::make('status')
                            ->label('Stato')
                            ->options(BookingStatus::class)
                            ->default(BookingStatus::Pending)
                            ->required()
                            ->native(false),

                        DateTimePicker::make('confirmed_at')
                            ->label('Confermata il')
                            ->native(false)
                            ->displayFormat('d/m/Y H:i'),

                        DateTimePicker::make('completed_at')
                            ->label('Completata il')
                            ->native(false)
                            ->displayFormat('d/m/Y H:i'),

                        Textarea::make('notes')
                            ->label('Note Interne')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Note per uso interno (non visibili al cliente)'),
                    ])
                    ->columns(3),
            ]);
    }
}
