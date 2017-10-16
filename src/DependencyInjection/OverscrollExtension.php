<?php

namespace HeimrichHannot\OverscrollBundle\DependencyInjection;

use Behat\Gherkin\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class OverscrollExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container, new FileLocator(__DIR__ . '/../Resources/config')
        );

        $loader->load('listener.yml');
    }
}
