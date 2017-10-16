<?php

namespace HeimrichHannot\OverscrollBundle\EventListener;

use Contao\FrontendTemplate;
use Contao\ModuleModel;
use HeimrichHannot\Blocks\BlockModuleModel;
use HeimrichHannot\OverscrollBundle\Backend\BlockModule;

class HookListener extends \Controller
{
    public function __construct()
    {
    }

    public function renderOverscrollBlock($page, $layout, &$handler)
    {
        $overscrollModule = false;

        foreach (deserialize($layout->modules, true) as $index => $module) {
            if ($module['col'] == 'overscroll') {
                $overscrollModule = $module['mod'];
            }
        }

        if ($overscrollModule === false) {
            return;
        }

        if (($module = ModuleModel::findByPk($overscrollModule)) === null || !$module->block) {
            return;
        }

        if (($blockModule = BlockModuleModel::findByPid($module->block)) === null || $blockModule->type != 'overscroll') {
            return;
        }

        $parsedSections = '';

        foreach (deserialize($blockModule->overscrollLayoutSections, true) as $section)
        {
            $frontendTemplate = new FrontendTemplate('section_' . $section);
            $frontendTemplate->{$section} = $handler->Template->sections[$section];

            $parsedSections .= $frontendTemplate->parse();
        }

        $sections = $handler->Template->sections;
        $sections['overscroll'] = $parsedSections;

        $handler->Template->__set('sections', $sections);
    }
}