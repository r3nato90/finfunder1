<?php

namespace App\Enums;

enum SupportTicketStatus: int
{
    use EnumTrait;

    case RUNNING = 1;
    case ANSWERED = 2;
    case REPLIED = 3;
    case CLOSED = 4;

    public static function getColor(int $status): string {
        return match($status) {
            self::RUNNING->value => 'badge--primary',
            self::ANSWERED->value => 'badge--success',
            self::REPLIED->value => 'badge--info',
            self::CLOSED->value => 'badge--danger',
            default => 'black'
        };
    }

    public static function getName(int $status): string {
        return match($status) {
            self::RUNNING->value => 'Running',
            self::ANSWERED->value => 'Answered',
            self::REPLIED->value => 'Replied',
            self::CLOSED->value => 'Closed',
            default => 'Default'
        };
    }
}
