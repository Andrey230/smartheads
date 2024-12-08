<?php

namespace App\Event;

use App\Entity\Letter;
use Symfony\Contracts\EventDispatcher\Event;

class LetterSentEvent extends Event
{
    public const NAME = 'letter.sent';

    private Letter $letter;

    public function __construct(Letter $letter)
    {
        $this->letter = $letter;
    }

    public function getLetter(): Letter
    {
        return $this->letter;
    }
}
