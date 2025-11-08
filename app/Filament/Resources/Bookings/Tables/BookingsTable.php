<?php

declare(strict_types=1);

namespace App\Filament\Resources\Bookings\Tables;

use App\Enums\BookingStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer_name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('service.name')
                    ->label('Servizio')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('pet_name')
                    ->label('Nome Pet')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Stato')
                    ->badge()
                    ->sortable(),

                TextColumn::make('preferred_date')
                    ->label('Data Richiesta')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('preferred_time')
                    ->label('Ora Richiesta')
                    ->time('H:i')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('customer_email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('customer_phone')
                    ->label('Telefono')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('pet_species')
                    ->label('Specie')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('confirmed_at')
                    ->label('Confermata il')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('completed_at')
                    ->label('Completata il')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Creata il')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Aggiornata il')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Stato')
                    ->options(BookingStatus::class)
                    ->native(false),

                SelectFilter::make('service')
                    ->label('Servizio')
                    ->relationship('service', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
