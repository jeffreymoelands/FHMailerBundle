<?php
declare(strict_types=1);

namespace FH\Bundle\MailerBundle\Composer;

use FH\Bundle\MailerBundle\Email\MessageOptions;
use Symfony\Component\Mailer\Exception\InvalidArgumentException;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\RawMessage;

final class EmailComposer implements ComposerInterface
{
    private $messageOptions;

    public function __construct(MessageOptions $messageOptions)
    {
        $this->messageOptions = $messageOptions;
    }

    /**
     * @return Email
     */
    public function compose(array $context, RawMessage $message = null): RawMessage
    {
        $message = $message ?: new Email();

        if (!$message instanceof Email) {
            throw new InvalidArgumentException(
                sprintf('Expected instance of %s, instance of %s given', Email::class,  get_class($message))
            );
        }

        (new ApplyEmailMessageOptions())->apply($message, $this->messageOptions);

        return $message;
    }
}
