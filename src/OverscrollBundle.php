<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\OverscrollBundle;

use HeimrichHannot\OverscrollBundle\DependencyInjection\OverscrollExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class OverscrollBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new OverscrollExtension();
    }
}
