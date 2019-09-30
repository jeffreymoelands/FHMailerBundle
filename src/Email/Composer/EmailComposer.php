<?php
declare(strict_types=1);

namespace FH\MailerBundle\Email\Composer;

use Symfony\Component\Mailer\Exception\InvalidArgumentException;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\RawMessage;

class EmailComposer implements ComposerInterface
{
    private $composer;

    public function __construct(?ComposerInterface $composer)
    {
        $this->composer = $composer;
    }

    /**
     * @return Email
     */
    public function compose(array $context, RawMessage $message = null): RawMessage
    {
        $message = $message ?: new Email();

        if ($this->composer instanceof ComposerInterface) {
            $message = $this->composer->compose($context, $message);
        }

        if (!$message instanceof Email) {
            throw new InvalidArgumentException(sprintf('Expected instance of %s, instance of %s given', Email::class, get_class($message)));
        }

        if (array_key_exists('subject', $context) && !is_string($message->getSubject())) {
            $message->subject($context['subject']);
        }

        if (array_key_exists('from', $context)) {
            $message->from($context['from']);
        }

        if (array_key_exists('to', $context)) {
            $message->to($context['to']);
        }

        if (array_key_exists('cc', $context)) {
            $message->cc($context['cc']);
        }

        if (array_key_exists('bcc', $context)) {
            $message->bcc($context['bcc']);
        }

        return $message;
    }
}
