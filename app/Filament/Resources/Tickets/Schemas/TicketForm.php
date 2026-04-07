<?php

namespace App\Filament\Resources\Tickets\Schemas;

use App\Enums\TicketStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class TicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Ticket Info')
                    ->schema([

                        Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->required(),
                        TextInput::make('title')
                            ->required(),
                        Textarea::make('description')
                            ->columnSpanFull(),
                        Select::make('status')
                            ->options(TicketStatus::class)
                            ->default('new')
                            ->required(),
                        DateTimePicker::make('answered_at'),
                    ])
                    ->columnSpanFull()
                    ->columns(2),

                Section::make('Ticket Files')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('attachments')
                            ->collection('attachments')
                            ->multiple()
                            ->downloadable()
                            ->openable()
                            ->reorderable()
                            ->maxFiles(10)
                            ->helperText('Files saved via Spatie Media Library.'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
