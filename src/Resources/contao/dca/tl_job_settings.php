<?php

use Contao\DC_File;

$strName = 'tl_job_settings';

$GLOBALS['TL_DCA'][$strName] = array
(
    // Config
    'config' => array
    (
        'dataContainer' => DC_File::class,
        'closed' => true
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__' => array(),
        'default' => '
			{structuredData_legend},contaojobsbundle_structuredData_hiringOrganization,contaojobsbundle_structuredData_jobLocation;
		'
    ),

    // Subpalettes
    'subpalettes' => array
    (
    ),

    // Fields
    'fields' => array
    (
        'contaojobsbundle_structuredData_hiringOrganization' => array
        (
            'inputType'               => 'textarea',
            'eval'                    => array('style'=>'height:120px', 'preserveTags'=>true, 'class'=>'monospace', 'rte'=>'ace|html', 'tl_class'=>'clr'),
        )
    )
);
