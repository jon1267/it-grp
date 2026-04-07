<?php

namespace App\Filament\Resources\Tickets\Tables;

use App\Enums\TicketStatus;
use Filament\Tables\Columns\SelectColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('customer.name')
                    ->label('Name')
                    ->limit(20)
                    ->searchable(),
                TextColumn::make('customer.phone')
                    ->label('Phone')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('customer.email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('title')
                    ->limit(20)
                    ->searchable(),
                // TextColumn::make('status')
                //     ->sortable()
                //     ->badge(),
                SelectColumn::make('status')
                    ->label('Status')
                    ->options(TicketStatus::class)
                    ->selectablePlaceholder(false)
                    ->native(false),
                TextColumn::make('answered_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);

    }
}
