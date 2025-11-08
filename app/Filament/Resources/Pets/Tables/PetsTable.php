<?php

declare(strict_types=1);

namespace App\Filament\Resources\Pets\Tables;

use App\Enums\PetSpecies;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('species')
                    ->label('Specie')
                    ->badge()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('owner_name')
                    ->label('Proprietario')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('death_date')
                    ->label('Data Morte')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('is_published')
                    ->label('Pubblicato')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('published_at')
                    ->label('Pubblicato il')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('hearts_count')
                    ->label('❤️')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('candles_count')
                    ->label('🕯️')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('created_at')
                    ->label('Creato il')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Aggiornato il')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('species')
                    ->label('Specie')
                    ->options(PetSpecies::class)
                    ->multiple(),

                TernaryFilter::make('is_published')
                    ->label('Stato Pubblicazione')
                    ->placeholder('Tutti')
                    ->trueLabel('Pubblicati')
                    ->falseLabel('Non Pubblicati'),

                TrashedFilter::make()
                    ->label('Eliminati'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
