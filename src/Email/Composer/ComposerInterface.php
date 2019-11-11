<?php
declare(strict_types=1);

namespace FH\Bundle\MailerBundle\Email\Composer;

use Symfony\Component\Mime\RawMessage;

interface ComposerInterface
{
    public function compose(array $context, RawMessage $message = null): RawMessage;
}
