<?php

namespace HeimrichHannot\OverscrollBundle\EventListener;

use Contao\FrontendTemplate;
use Contao\ModuleModel;
use Contao\PageModel;
use HeimrichHannot\Blocks\BlockModuleModel;
use HeimrichHannot\Haste\Util\Url;
use HeimrichHannot\OverscrollBundle\Backend\BlockModule;

class HookListener extends \Controller
{
    private static $defaultSections = [
        'header',
        'left',
        'right',
        'main',
        'footer'
    ];

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

        foreach (deserialize($blockModule->overscrollLayoutSections, true) as $section) {
            $frontendTemplate             = new FrontendTemplate('section_' . $section);
            $frontendTemplate->{$section} = in_array($section, static::$defaultSections) ?
                $handler->Template->{$section} : $handler->Template->sections[$section];

            $parsedSections .= $frontendTemplate->parse();
        }

        $sections = $handler->Template->sections;

        $frontendTemplate                    = new FrontendTemplate('section_overscroll');
        $frontendTemplate->overscroll        = $parsedSections;
        $frontendTemplate->lineColor         = $blockModule->overscrollLineColor;
        $frontendTemplate->lineColorFinished = $blockModule->overscrollLineColorFinished;
        $frontendTemplate->caption           = html_entity_decode($blockModule->overscrollCaption);
        $frontendTemplate->jumpTo            = $blockModule->overscrollJumpTo;

        /** $page PageModel */
        if (($page = PageModel::findByPk($blockModule->overscrollJumpTo)) !== null) {
            $frontendTemplate->jumpToUrl = $page->getFrontendUrl();
        }

        $height = deserialize($blockModule->overscrollHeight, true);

        $frontendTemplate->height = $height['value'] . $height['unit'];

        if (isset($GLOBALS['TL_HOOKS']['adjustOverscroll']) && is_array($GLOBALS['TL_HOOKS']['adjustOverscroll']))
        {
            foreach ($GLOBALS['TL_HOOKS']['adjustOverscroll'] as $callback)
            {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($frontendTemplate, $blockModule, $page, $layout);
            }
        }

        $sections['overscroll'] = $frontendTemplate->parse();

        $handler->Template->__set('sections', $sections);
    }
}