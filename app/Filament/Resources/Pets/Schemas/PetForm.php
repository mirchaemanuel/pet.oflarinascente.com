<?php

declare(strict_types=1);

namespace App\Filament\Resources\Pets\Schemas;

use App\Enums\PetSpecies;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informazioni Pet')
                    ->description('Dati principali del pet')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),

                        Select::make('species')
                            ->label('Specie')
                            ->options(PetSpecies::class)
                            ->required()
                            ->native(false),

                        TextInput::make('breed')
                            ->label('Razza')
                            ->maxLength(255),
                    ])
                    ->columns(3),

                Section::make('Date e Età')
                    ->schema([
                        DatePicker::make('birth_date')
                            ->label('Data di Nascita')
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        DatePicker::make('death_date')
                            ->label('Data di Morte')
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        Fieldset::make('Età')
                            ->schema([
                                TextInput::make('age_years')
                                    ->label('Anni')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(50),

                                TextInput::make('age_months')
                                    ->label('Mesi')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(11),
                            ])
                            ->columns(2),
                    ])
                    ->columns(3),

                Section::make('Dedica e Storia')
                    ->schema([
                        Textarea::make('dedication')
                            ->label('Dedica')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        Textarea::make('story')
                            ->label('Storia')
                            ->rows(5)
                            ->maxLength(2000)
                            ->columnSpanFull(),
                    ]),

                Section::make('Proprietario')
                    ->description('Informazioni opzionali del proprietario')
                    ->schema([
                        TextInput::make('owner_name')
                            ->label('Nome Proprietario')
                            ->maxLength(255),

                        TextInput::make('owner_email')
                            ->label('Email Proprietario')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('owner_phone')
                            ->label('Telefono Proprietario')
                            ->tel()
                            ->maxLength(255),
                    ])
                    ->columns(3)
                    ->collapsible(),

                Section::make('Pubblicazione')
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Pubblicato')
                            ->helperText('Il memoriale sarà visibile pubblicamente'),
                    ])
                    ->collapsible(),
            ]);
    }
}
