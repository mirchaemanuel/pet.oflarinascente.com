<?php

declare(strict_types=1);

namespace App\Filament\Resources\Settings\Settings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Chiave')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Chiave copiata!')
                    ->weight('bold')
                    ->color('primary'),

                TextColumn::make('value')
                    ->label('Valore')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen((string) $state) <= 50) {
                            return null;
                        }

                        return $state;
                    })
                    ->wrap(),

                TextColumn::make('group')
                    ->label('Gruppo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'general' => 'gray',
                        'contact' => 'info',
                        'business' => 'success',
                        'social' => 'warning',
                        'seo' => 'primary',
                        'advanced' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'general' => 'Generali',
                        'contact' => 'Contatti',
                        'business' => 'Informazioni Aziendali',
                        'social' => 'Social Media',
                        'seo' => 'SEO',
                        'advanced' => 'Avanzate',
                        default => $state,
                    })
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'text' => 'Testo',
                        'textarea' => 'Testo lungo',
                        'number' => 'Numero',
                        'boolean' => 'Sì/No',
                        'email' => 'Email',
                        'tel' => 'Telefono',
                        'url' => 'URL',
                        default => $state,
                    })
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('description')
                    ->label('Descrizione')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Ultimo Aggiornamento')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('group')
                    ->label('Gruppo')
                    ->options([
                        'general' => 'Generali',
                        'contact' => 'Contatti',
                        'business' => 'Informazioni Aziendali',
                        'social' => 'Social Media',
                        'seo' => 'SEO',
                        'advanced' => 'Avanzate',
                    ]),

                SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'text' => 'Testo',
                        'textarea' => 'Testo lungo',
                        'number' => 'Numero',
                        'boolean' => 'Sì/No',
                        'email' => 'Email',
                        'tel' => 'Telefono',
                        'url' => 'URL',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('group', 'asc')
            ->groups([
                'group',
            ]);
    }
}
