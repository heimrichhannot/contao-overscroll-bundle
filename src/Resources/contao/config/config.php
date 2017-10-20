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
    'js' => [
        'files' => [
            'bundles/overscroll/js/overscroll.min.js|static'
        ],
    ],
];

$GLOBALS['TL_COMPONENTS']['overscroll.css'] = [
    'css' => [
        'files' => [
            'bundles/overscroll/css/overscroll.css|screen|static'
        ]
    ],
];