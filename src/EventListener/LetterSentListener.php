<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Event\LetterSentEvent;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class LetterSentListener implements EventSubscriberInterface
{
    const EMAIL_RECEIVER = 'biuro@smartheads.pl';
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function onLetterSent(LetterSentEvent $event)
    {
        $letter = $event->getLetter();

        $email = (new TemplatedEmail())
            ->from('noreply@yourdomain.com')
            ->to(self::EMAIL_RECEIVER)
            ->subject('New letter received')
            ->htmlTemplate('/letter/template_email.html.twig')
            ->context([
                'letter' => $letter,
            ]);

        $this->mailer->send($email);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LetterSentEvent::NAME => 'onLetterSent',
        ];
    }
}
