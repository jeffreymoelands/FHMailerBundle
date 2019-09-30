<?php
declare(strict_types=1);

namespace FH\MailerBundle\DependencyInjection\Compiler;

use FH\MailerBundle\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class MailerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $mailers = $container->findTaggedServiceIds(Configuration::SERVICE_TAG);

        foreach ($mailers as $mailerId => $tags) {
            foreach ($tags as $tag) {
                $composerId = $tag['composer'];
                $composerId = Configuration::COMPOSER_PREFIX . $composerId;

                $mailer = $container->getDefinition($mailerId);
                $mailer->setArgument('$composer', new Reference($composerId));
            }
        }
    }
}
