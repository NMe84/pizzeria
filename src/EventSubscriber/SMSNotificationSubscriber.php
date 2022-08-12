<?php

namespace App\EventSubscriber;

use App\Enum\NotificationType;
use App\Event\OrderStatusUpdateEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SMSNotificationSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected readonly LoggerInterface $logger,
    ) {
    }

    public static function getSubscribedEvents(): iterable
    {
        yield OrderStatusUpdateEvent::class => 'onStatusUpdated';
    }

    public function onStatusUpdated(OrderStatusUpdateEvent $event): void
    {
        if (NotificationType::SMS !== $event->getOrder()->getSendStatusUpdatesTo()) {
            return;
        }

        // Logic to send text messages here. See the EmailNotificationSubscriber for a semi-full implementation of a subscriber.
    }
}
