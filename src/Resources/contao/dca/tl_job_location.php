<?php

namespace Duncrow\JobsBundle\Resources\contao\dca;

use Contao\Backend;
use Contao\BackendUser;
use Contao\DataContainer;
use Contao\DC_Table;
use Contao\System;

$GLOBALS['TL_DCA']['tl_job_location'] = array
(
    // Config
    'config' => array
    (
        'dataContainer' => DC_Table::class,
        'switchToEdit' => true,
        'enableVersioning' => true,
        'onload_callback' => array(),
        'oncreate_callback' => array(),
        'oncopy_callback' => array(),
        'onsubmit_callback' => array(),
        'oninvalidate_cache_tags_callback' => array(),
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary'
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'panelLayout' => 'filter;search,limit'
        ),
        'label' => array
        (
            'fields' => array('street', 'postal', 'city'),
            'format' => '%s <span class="tl_gray" style="margin-left: 3px;">[%s %s]</span>'
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'editheader' => array
            (
                'href' => 'act=edit',
                'icon' => 'header.svg',
            ),
            'copy' => array
            (
                'href' => 'act=copy',
                'icon' => 'copy.svg',
            ),
            'delete' => array
            (
                'href' => 'act=delete',
                'icon' => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"',
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__' => array(),
        'default' => '{address_legend},street,postal,city,state,country;'
    ),

    // Subpalettes
    'subpalettes' => array
    (),

    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql' => "int(10) unsigned NOT NULL default 0"
        ),
        'street' => array
        (
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => array('mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'postal' => array
        (
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => array('mandatory' => true, 'maxlength' => 32, 'tl_class' => 'w50 clr'),
            'sql' => "varchar(32) NOT NULL default ''"
        ),
        'city' => array
        (
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'state' => array
        (
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql' => "varchar(64) NOT NULL default ''"
        ),
        'country' => array
        (
            'exclude' => true,
            'filter' => true,
            'sorting' => true,
            'inputType' => 'select',
            'eval' => array('mandatory' => true, 'includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50'),
            'options_callback' => static function () {
                $countries = System::getContainer()->get('contao.intl.countries')->getCountries();

                // Convert to lower case for backwards compatibility, to be changed in Contao 5.0
                return array_combine(array_map('strtolower', array_keys($countries)), $countries);
            },
            'sql' => "varchar(2) NOT NULL default ''"
        )
    )
);

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_job_location extends Backend
{
    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import(BackendUser::class, 'User');
    }
}
