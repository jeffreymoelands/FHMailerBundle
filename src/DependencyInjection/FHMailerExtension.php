<?php
declare(strict_types=1);

namespace FH\MailerBundle\DependencyInjection;

use FH\MailerBundle\Email\Composer\EmailComposer;
use FH\MailerBundle\Email\Composer\TemplatedEmailComposer;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

final class FHMailerExtension extends ConfigurableExtension
{
    public function loadInternal(array $configs, ContainerBuilder $container): void
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../../config'));
        $loader->load('message_composer.yaml');

        $composerConfigs = $configs['message_composers'];

        foreach ($composerConfigs as $identifier => $config) {
            $composerDefinition = new ChildDefinition(EmailComposer::class);
            $composerDefinition->setPublic(true);
            $composerId = 'fh_mailer.composer_email.' . $identifier;
            $container->setDefinition($composerId, $composerDefinition);

            $composerDefinition = new ChildDefinition(TemplatedEmailComposer::class);
            $composerDefinition->setArgument('$composer', new Reference($composerId));
            $composerDefinition->setPublic(true);
            $composerId = Configuration::COMPOSER_PREFIX . $identifier;
            $container->setDefinition($composerId, $composerDefinition);
        }
    }
}
