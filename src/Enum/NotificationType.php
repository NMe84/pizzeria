<?php

declare(strict_types=1);

namespace App\Enum;

// I'm going for a class rather than an enum here because making enums work in Doctrine takes more time than this assignment warrants.
class NotificationType
{
    public const EMAIL = 'email';
    public const SMS = 'sms';

    public const ALL = [
        self::EMAIL,
        self::SMS,
    ];
}
