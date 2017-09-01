<?php

namespace TEAEbook\Bundle\CrontabBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

class CrontabExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration($this->getConfiguration($configs, $container), $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $container->getDefinition('crontab.finder.jobs')
            ->replaceArgument(0, $config['jobs'])
            ->replaceArgument(1, $config['working_directory'] ? realpath($config['working_directory']) : '');
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'crontab';
    }
}
