<?php
declare(strict_types=1);

namespace FH\MailerBundle;

use FH\MailerBundle\DependencyInjection\Compiler\MailerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class FHMailerBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new MailerPass());
    }
}
