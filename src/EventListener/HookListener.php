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

    const OVERSCROLL_REPLACE_PATTERN = '<!-- overscroll.content -->';

    public function __construct()
    {
    }

    public function renderOverscrollBlockModule($blockModule, $return)
    {
        switch ($blockModule->type) {
            case 'overscroll':
                return static::OVERSCROLL_REPLACE_PATTERN;
                break;
        }

        return $return;
    }

    public function generateOverscroll($page, $layout, &$handler)
    {
        $sections = $handler->Template->sections;

        if (!isset($sections['overscroll']) || strpos($sections['overscroll'], static::OVERSCROLL_REPLACE_PATTERN) === false) {
            return;
        }

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

        $parsedSections  = '';
        $visibleSections = deserialize($blockModule->overscrollLayoutSections, true);

        foreach ($visibleSections as $section) {
            $frontendTemplate             = new FrontendTemplate('section_' . $section);
            $frontendTemplate->{$section} = in_array($section, static::$defaultSections) ?
                $handler->Template->{$section} : $handler->Template->sections[$section];

            $parsedSections .= $frontendTemplate->parse();
        }

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

        if (isset($GLOBALS['TL_HOOKS']['adjustOverscroll']) && is_array($GLOBALS['TL_HOOKS']['adjustOverscroll'])) {
            foreach ($GLOBALS['TL_HOOKS']['adjustOverscroll'] as $callback) {
                $this->import($callback[0]);
                $this->{$callback[0]}->{$callback[1]}($frontendTemplate, $blockModule, $page, $layout);
            }
        }

        $sections['overscroll'] = str_replace(static::OVERSCROLL_REPLACE_PATTERN,
            $frontendTemplate->parse(), $sections['overscroll']);

        $hiddenSections = deserialize($blockModule->overscrollHiddenLayoutSections, true);

        foreach ($hiddenSections as $hiddenSection) {
            if (in_array($hiddenSection, $visibleSections)) {
                unset($sections[$hiddenSection]);
            }
        }

        $handler->Template->__set('sections', $sections);
    }
}