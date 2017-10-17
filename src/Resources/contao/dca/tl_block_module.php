<?php

$dca = &$GLOBALS['TL_DCA']['tl_block_module'];

/**
 * Palettes
 */
$dca['palettes']['overscroll'] = '{type_legend},type;{overscroll_legend},overscrollLayoutSections,overscrollJumpTo,overscrollHeight,overscrollCaption,overscrollLineColor,overscrollLineColorFinished;{page_legend},addVisibility,pages,addPageDepth,keywords;{feature_legend},feature;{hide_legend},hide;{expert_legend:hide},addWrapper';

/**
 * Fields
 */
$fields = [
    'overscrollLayoutSections'    => [
        'label'            => &$GLOBALS['TL_LANG']['tl_block_module']['overscrollLayoutSections'],
        'exclude'          => true,
        'inputType'        => 'checkboxWizard',
        'options_callback' => ['HeimrichHannot\OverscrollBundle\Backend\BlockModule', 'getLayoutSectionsAsOptions'],
        'eval'             => ['tl_class' => 'w50', 'multiple' => true],
        'sql'              => "blob NULL'"
    ],
    'overscrollHeight'            => [
        'label'     => &$GLOBALS['TL_LANG']['tl_block_module']['overscrollHeight'],
        'exclude'   => true,
        'inputType' => 'inputUnit',
        'options'   => $GLOBALS['TL_CSS_UNITS'],
        'eval'      => ['includeBlankOption' => true, 'tl_class' => 'w50'],
        'sql'       => ['type' => 'string', 'default' => 'a:2:{s:4:"unit";s:2:"px";s:5:"value";s:4:"1000";}']
    ],
    'overscrollCaption'           => [
        'label'     => &$GLOBALS['TL_LANG']['tl_block_module']['overscrollCaption'],
        'exclude'   => true,
        'search'    => true,
        'inputType' => 'text',
        'eval'      => ['maxlength' => 128, 'tl_class' => 'w50', 'mandatory' => true],
        'sql'       => "varchar(128) NOT NULL default ''"
    ],
    'overscrollLineColor'         => [
        'label'     => &$GLOBALS['TL_LANG']['tl_block_module']['overscrollLineColor'],
        'exclude'   => true,
        'search'    => true,
        'inputType' => 'text',
        'eval'      => ['maxlength' => 32, 'tl_class' => 'w50'],
        'sql'       => "varchar(32) NOT NULL default ''"
    ],
    'overscrollLineColorFinished' => [
        'label'     => &$GLOBALS['TL_LANG']['tl_block_module']['overscrollLineColorFinished'],
        'exclude'   => true,
        'search'    => true,
        'inputType' => 'text',
        'eval'      => ['maxlength' => 32, 'tl_class' => 'w50'],
        'sql'       => "varchar(32) NOT NULL default ''"
    ],
    'overscrollJumpTo'                      => [
        'label'      => &$GLOBALS['TL_LANG']['tl_block_module']['overscrollJumpTo'],
        'exclude'    => true,
        'inputType'  => 'pageTree',
        'foreignKey' => 'tl_page.title',
        'eval'       => ['fieldType' => 'radio', 'tl_class' => 'w50'],
        'sql'        => "int(10) unsigned NOT NULL default '0'",
        'relation'   => ['type' => 'hasOne', 'load' => 'eager']
    ],
];

$dca['fields'] += $fields;

$dca['fields']['type']['options'][] = 'overscroll';