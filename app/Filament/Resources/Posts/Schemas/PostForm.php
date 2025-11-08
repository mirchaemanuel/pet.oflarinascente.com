<?php

declare(strict_types=1);

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informazioni Articolo')
                    ->description('Dati principali dell\'articolo')
                    ->schema([
                        TextInput::make('title')
                            ->label('Titolo')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, ?string $state, callable $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                            ->columnSpanFull(),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('L\'URL dell\'articolo (generato automaticamente dal titolo)')
                            ->columnSpan(2),

                        Select::make('author_id')
                            ->label('Autore')
                            ->relationship('author', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(1),
                    ])
                    ->columns(3),

                Section::make('Contenuto')
                    ->schema([
                        Textarea::make('excerpt')
                            ->label('Estratto')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Breve riassunto dell\'articolo (massimo 500 caratteri)')
                            ->columnSpanFull(),

                        RichEditor::make('content')
                            ->label('Contenuto')
                            ->required()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'h2',
                                'h3',
                                'bulletList',
                                'orderedList',
                                'blockquote',
                                'codeBlock',
                                'undo',
                                'redo',
                            ])
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Immagine in Evidenza')
                    ->schema([
                        FileUpload::make('featured_image_path')
                            ->label('Immagine')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(2048)
                            ->directory('posts/featured-images')
                            ->helperText('Immagine principale dell\'articolo (max 2MB)')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Pubblicazione')
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Pubblicato')
                            ->helperText('L\'articolo sarà visibile pubblicamente')
                            ->default(false)
                            ->inline(false),

                        DateTimePicker::make('published_at')
                            ->label('Data di Pubblicazione')
                            ->native(false)
                            ->displayFormat('d/m/Y H:i')
                            ->helperText('Lasciare vuoto per pubblicare immediatamente'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('SEO')
                    ->description('Ottimizzazione per i motori di ricerca')
                    ->schema([
                        TextInput::make('meta_description')
                            ->label('Meta Description')
                            ->maxLength(160)
                            ->helperText('Descrizione per i motori di ricerca (max 160 caratteri)')
                            ->columnSpanFull(),

                        TextInput::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->maxLength(255)
                            ->helperText('Parole chiave separate da virgola')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
