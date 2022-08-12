<?php

namespace App\EventSubscriber;

use App\Enum\NotificationType;
use App\Event\OrderStatusUpdateEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime;

class EmailNotificationSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected readonly MailerInterface $mailer,
        protected readonly LoggerInterface $logger,
    ) {
    }

    public static function getSubscribedEvents(): iterable
    {
        yield OrderStatusUpdateEvent::class => 'onStatusUpdated';
    }

    public function onStatusUpdated(OrderStatusUpdateEvent $event): void
    {
        if (NotificationType::EMAIL !== $event->getOrder()->getSendStatusUpdatesTo()) {
            return;
        }

        try {
            $subject = 'Orderstatus bijgewerkt';

            $message = new Mime\Email();
            $message
                ->subject($subject)
                ->to(new Mime\Address($event->getOrder()->getEmail()))
                ->from(new Mime\Address('notifications@localhost'))
                ->replyTo(new Mime\Address('orders@localhost'))
            ;
            $message->text('De status van uw bestelling is bijgewerkt naar ' . $event->getOrder()->getStatus());

            $this->mailer->send($message);
            $this->logger->debug("Successfully sent email with subject '{$subject}' to {$event->getOrder()->getEmail()}.");
        } catch (\Throwable $exception) {
            $this->logger->error("Failed sending email with subject '{$subject}' to {$event->getOrder()->getEmail()}.");
        }
    }
}
