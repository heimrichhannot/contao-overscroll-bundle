<?php

$dca = &$GLOBALS['TL_DCA']['tl_block_module'];

/**
 * Palettes
 */
$dca['palettes']['overscroll'] = '{type_legend},type;{overscroll_legend},overscrollLayoutSections,overscrollHeight;{page_legend},addVisibility,pages,addPageDepth,keywords;{feature_legend},feature;{hide_legend},hide;{expert_legend:hide},addWrapper';

/**
 * Fields
 */
$fields = [
    'overscrollLayoutSections' => [
        'label'            => &$GLOBALS['TL_LANG']['tl_block_module']['overscrollLayoutSections'],
        'exclude'          => true,
        'inputType'        => 'checkboxWizard',
        'options_callback' => ['HeimrichHannot\OverscrollBundle\Backend\BlockModule', 'getLayoutSectionsAsOptions'],
        'eval'             => ['tl_class' => 'w50', 'multiple' => true],
        'sql'              => "blob NULL'"
    ],
    'overscrollHeight'         => [
        'label'     => &$GLOBALS['TL_LANG']['tl_block_module']['overscrollHeight'],
        'exclude'   => true,
        'inputType' => 'inputUnit',
        'options'   => $GLOBALS['TL_CSS_UNITS'],
        'eval'      => ['includeBlankOption' => true, 'tl_class' => 'w50'],
        'sql'       => ['type' => 'string', 'default' => 'a:2:{s:4:"unit";s:2:"px";s:5:"value";s:4:"1000";}']
    ],
];

$dca['fields'] += $fields;

$dca['fields']['type']['options'][] = 'overscroll';