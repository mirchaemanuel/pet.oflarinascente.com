<?php

declare(strict_types=1);

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informazioni Servizio')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome Servizio')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state): void {
                                if (($get('slug') ?? '') !== Str::slug($old)) {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            }),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Generato automaticamente dal nome'),

                        Toggle::make('is_active')
                            ->label('Attivo')
                            ->default(true)
                            ->helperText('Il servizio sarà visibile pubblicamente'),

                        TextInput::make('order')
                            ->label('Ordine')
                            ->numeric()
                            ->default(0)
                            ->helperText('Ordine di visualizzazione (0 = primo)'),
                    ])
                    ->columns(2),

                Section::make('Descrizioni')
                    ->schema([
                        Textarea::make('description')
                            ->label('Descrizione Breve')
                            ->required()
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpanFull(),

                        RichEditor::make('detailed_description')
                            ->label('Descrizione Dettagliata')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                            ])
                            ->columnSpanFull(),
                    ]),

                Section::make('Prezzi')
                    ->schema([
                        TextInput::make('price_from')
                            ->label('Prezzo Da (€)')
                            ->numeric()
                            ->prefix('€')
                            ->step(0.01),

                        TextInput::make('price_notes')
                            ->label('Note Prezzo')
                            ->maxLength(255)
                            ->helperText('Es: "a partire da", "su richiesta"'),
                    ])
                    ->columns(2),

                Section::make('Caratteristiche')
                    ->schema([
                        Repeater::make('features')
                            ->label('Caratteristiche')
                            ->schema([
                                TextInput::make('feature')
                                    ->label('Caratteristica')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->defaultItems(0)
                            ->addActionLabel('Aggiungi Caratteristica')
                            ->columnSpanFull()
                            ->reorderable()
                            ->collapsible(),
                    ]),

                Section::make('SEO')
                    ->description('Ottimizzazione per motori di ricerca')
                    ->schema([
                        TextInput::make('meta_description')
                            ->label('Meta Description')
                            ->maxLength(160)
                            ->helperText('Massimo 160 caratteri'),

                        TextInput::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->maxLength(255)
                            ->helperText('Separati da virgola'),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }
}
