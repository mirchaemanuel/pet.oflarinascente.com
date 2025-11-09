<?php

declare(strict_types=1);

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informazioni Contatto')
                    ->description('Dati del contatto ricevuto')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->disabled()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->disabled()
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('Telefono')
                            ->tel()
                            ->disabled()
                            ->maxLength(255),

                        TextInput::make('subject')
                            ->label('Oggetto')
                            ->required()
                            ->disabled()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Textarea::make('message')
                            ->label('Messaggio')
                            ->required()
                            ->disabled()
                            ->rows(5)
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Section::make('Gestione')
                    ->schema([
                        Toggle::make('is_read')
                            ->label('Letto')
                            ->helperText('Segna come letto')
                            ->default(false),

                        DateTimePicker::make('read_at')
                            ->label('Letto il')
                            ->native(false)
                            ->displayFormat('d/m/Y H:i')
                            ->helperText('Data e ora di lettura'),

                        DateTimePicker::make('replied_at')
                            ->label('Risposto il')
                            ->native(false)
                            ->displayFormat('d/m/Y H:i')
                            ->helperText('Data e ora della risposta'),

                        Textarea::make('notes')
                            ->label('Note Interne')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Note per uso interno (non visibili al cliente)'),
                    ])
                    ->columns(3),

                Section::make('Informazioni Tecniche')
                    ->description('Dati tecnici della richiesta')
                    ->schema([
                        TextInput::make('ip_address')
                            ->label('Indirizzo IP')
                            ->disabled()
                            ->maxLength(45),

                        TextInput::make('user_agent')
                            ->label('User Agent')
                            ->disabled()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
