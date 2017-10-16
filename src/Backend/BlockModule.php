<?php

namespace HeimrichHannot\OverscrollBundle\Backend;

use Contao\Backend;
use Contao\LayoutModel;

class BlockModule extends Backend
{
    public static function getLayoutSectionsAsOptions(\DataContainer $objDc)
    {
        $options = [];

        foreach (['header', 'left', 'right', 'main', 'footer'] as $section)
        {
            $options[$section] = $GLOBALS['TL_LANG']['COLS'][$section];
        }

        // Add custom layout sections
        if (($layouts = LayoutModel::findAll()) !== null)
        {
            while ($layouts->next())
            {
                if ($layouts->sections != '') {
                    $sections = \StringUtil::deserialize($layouts->sections);

                    if (!empty($sections) && is_array($sections)) {
                        foreach ($sections as $v) {
                            if (!empty($v['id'])) {
                                $options[$v['id']] = $v['title'] ?: $v['id'];
                            }
                        }
                    }
                }
            }
        }

        asort($options);

        return $options;
    }
}