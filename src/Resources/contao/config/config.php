<?php

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['generatePage']['renderOverscrollBlock'] = ['huh.overscroll.listener.hooks', 'renderOverscrollBlock'];

/**
 * Components
 */
$GLOBALS['TL_COMPONENTS']['overscroll.js'] = [
    'js' => [
        'files' => [
            'bundles/overscroll/js/overscroll.js|static'
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