<?php
declare(strict_types=1);

namespace FH\MailerBundle\Email;

final class Participants
{
    private $from;
    private $to;
    private $cc;
    private $bcc;

    public function __construct(array $from = [], array $to = [], array $cc = [], array $bcc = [])
    {
    }
}
