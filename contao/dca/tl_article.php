<?php

use Contao\CoreBundle\DataContainer\PaletteManipulator;

$GLOBALS['TL_DCA']['tl_article']['fields']['hideInArticleList'] = [
    'exclude'                 => true,
    'filter'                  => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50'),
    'sql'                     => "char(1) NOT NULL default ''"
];

PaletteManipulator::create()
    ->addField('hideInArticleList', 'guests')
    ->applyToPalette('default', 'tl_article')
;
