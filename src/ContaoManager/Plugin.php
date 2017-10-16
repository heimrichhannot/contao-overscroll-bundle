<?php

namespace HeimrichHannot\OverscrollBundle\ContaoManager;

use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\CoreBundle\ContaoCoreBundle;
use HeimrichHannot\OverscrollBundle\OverscrollBundle;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(OverscrollBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
        ];
    }
}

