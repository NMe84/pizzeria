<?php

declare(strict_types=1);

namespace App\Enum;

// I'm going for a class rather than an enum here because making enums work in Doctrine takes more time than this assignment warrants.
class OrderStatus
{
    public const NEW = 'new';
    public const CONFIRMED = 'confirmed';
    public const BEING_PREPARED = 'beingPrepared';
    public const WAITING_FOR_PICKUP = 'waitingForPickup';
    public const BEING_DELIVERED = 'beingDelivered';
    public const FINALIZED = 'finalized';

    public const ALL = [
        self::NEW,
        self::CONFIRMED,
        self::BEING_PREPARED,
        self::WAITING_FOR_PICKUP,
        self::BEING_DELIVERED,
        self::FINALIZED,
    ];
}
