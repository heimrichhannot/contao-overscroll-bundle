<?php

namespace HeimrichHannot\OverscrollBundle\EventListener;


class HookListener extends \Controller
{
    public static function renderOverscrollBlockModule($blockModule)
    {
        return 'Hallo';
    }
}