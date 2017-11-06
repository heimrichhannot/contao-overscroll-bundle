<?php

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['renderCustomBlockModule']['renderOverscrollBlockModule'] = ['huh.overscroll.listener.hooks', 'renderOverscrollBlockModule'];
$GLOBALS['TL_HOOKS']['generatePage']['generateOverscroll']                     = ['huh.overscroll.listener.hooks', 'generateOverscroll'];

/**
 * Components
 */
$GLOBALS['TL_COMPONENTS']['overscroll.js'] = [
    'js'  => [
        'bundles/overscroll/js/overscroll.min.js|static',
    ],
    'css' => [
        'bundles/overscroll/css/overscroll.css|screen|static',
    ],
];

if (TL_MODE == 'FE') {
    $GLOBALS['TL_JAVASCRIPT']['overscroll'] = 'bundles/overscroll/js/overscroll.min.js|static';
    $GLOBALS['TL_CSS']['overscroll']        = 'bundles/overscroll/css/overscroll.css|screen|static';
}


