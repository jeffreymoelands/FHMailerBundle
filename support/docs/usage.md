Usage
------------

```
// WelcomeEmail.php

namespace App\Email\WelcomeEmail;

use FH\Bundle\MailerBundle\Composer\TemplatedEmailComposer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

final class WelcomeEmail
{
    private $composer;
    private $mailer;

    public function __construct(TemplatedEmailComposer $composer, MailerInterface $mailer)
    {
        $this->composer = $composer;
        $this->mailer = $mailer;
    }

    public function send(Consumer $consumer): void
    {
        /** @var TemplatedEmail $templatedEmail */
        $templatedEmail = $this->composer->compose([
            'consumer' => $consumer
        ]);

        $this->mailer->send($templatedEmail);
    }
}
```

```
// config/services.yaml

services:
    ...

    App\Email\WelcomeEmail:
        $composer: '@fh_mailer.composer.templated_email.consumer_welcome'
```
