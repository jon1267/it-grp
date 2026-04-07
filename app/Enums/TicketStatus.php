<?php

namespace App\Enums;

enum TicketStatus: string
{
    case New = 'new';
    case Processing = 'processing';
    case Closed = 'closed';

    public static function values(): array
    {
        return array_map(
            static fn (self $status) => $status->value,
            self::cases()
        );
    }
}
