<?php

$strName = 'tl_job';
$strClass = '\Duncrow\JobsBundle\Backend\Job';
$this->loadDataContainer('tl_content');
$this->loadDataContainer('tl_module');

$GLOBALS['TL_DCA'][$strName] = array
(
    // Config
    'config' => array
    (
        'dataContainer' => 'Table',
        'ctable' => array('tl_content'),
        'switchToEdit' => true,
        'enableVersioning' => true,
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
                'alias' => 'index',
                'pid,start,stop,published' => 'index'
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode' => DataContainer::MODE_SORTED,
            'flag' => DataContainer::SORT_INITIAL_LETTER_ASC,
            'fields' => array('title'),
            'panelLayout' => 'filter;search'
        ),
        'label' => array
        (
            'fields' => array('title', 'language'),
            'format' => '%s <span class="tl_gray" style="margin-left: 3px;">[%s]</span>'
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'href' => 'table=tl_content',
                'icon' => 'edit.svg'
            ),
            'editheader' => array
            (
                'href' => 'act=edit',
                'icon' => 'header.svg'
            ),
            'copy' => array
            (
                'href' => 'act=copy',
                'icon' => 'copy.gif'
            ),
            'delete' => array
            (
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'toggle' => array
            (
                'href' => 'act=toggle&amp;field=published',
                'icon' => 'visible.svg',
                'button_callback' => array($strClass, 'toggleIcon'),
                'showInHeader' => true
            ),
            'feature' => array
            (
                'href' => 'act=toggle&amp;field=featured',
                'icon' => 'featured.svg',
                'button_callback' => array($strClass, 'featureIcon'),
                'showInHeader' => true
            ),
            'show' => array
            (
                'href' => 'act=show',
                'icon' => 'show.gif'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__' => array(),
        'default' => '
			{general_legend},title,alias,language,linkedJobs,description;
		    {publish_legend},published,featured,start,stop
		'
    ),

    // Subpalettes
    'subpalettes' => array
    (
    ),

    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'sorting' => array
        (
            'sql' => "int(10) NOT NULL default '1000'"
        ),
        'tstamp' => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),

        'title' => array
        (
            'search' => true,
            'inputType' => 'text',
            'eval' => array('mandatory' => true, 'allowHtml' => true, 'maxlength' => 255, 'tl_class' => 'clr w50'),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'alias' => array
        (
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => array('rgxp' => 'alias', 'doNotCopy' => true, 'unique' => false, 'maxlength' => 255, 'tl_class' => 'w50'),
            'save_callback' => array
            (
                array($strClass, 'generateAlias')
            ),
            'sql' => "varchar(255) BINARY NOT NULL default ''"
        ),
        'language' => array
        (
            'search' => true,
            'filter' => true,
            'inputType' => 'select',
            'options' => array('de' => 'Deutsch', 'en' => 'English'),
            'eval' => array('mandatory' => true, 'chosen' => true, 'submitOnChange' => true, 'tl_class' => 'clr w50'),
            'sql' => "varchar(255) NOT NULL default 'de'"
        ),
        'linkedJobs' => array
        (
            'exclude' => true,
            'inputType' => 'select',
            'options_callback' => array($strClass, 'getLinkedJobOptions'),
            'eval' => array('mandatory' => false, 'multiple' => true, 'chosen' => true, 'includeBlankOption' => true, 'tl_class' => 'w50'),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'description' => array
        (
            'search' => true,
            'inputType' => 'textarea',
            'eval' => array('mandatory' => false, 'rte' => 'tinyMCE', 'tl_class' => 'clr'),
            'sql' => "text NULL"
        ),

        'published' => array
        (
            'exclude' => true,
            'filter' => true,
            'toggle' => true,
            'inputType' => 'checkbox',
            'eval' => array('doNotCopy' => true, 'tl_class' => 'clr w50'),
            'sql' => "char(1) NOT NULL default '1'"
        ),
        'featured' => array
        (
            'exclude' => true,
            'filter' => true,
            'toggle' => true,
            'inputType' => 'checkbox',
            'eval' => array('doNotCopy' => true, 'tl_class' => 'w50'),
            'sql' => "char(1) NOT NULL default ''"
        ),
        'start' => array
        (
            'inputType' => 'text',
            'eval' => array('rgxp' => 'datim', 'datepicker' => true, 'tl_class' => 'w50 wizard'),
            'sql' => "varchar(11) NOT NULL default ''"
        ),
        'stop' => array
        (
            'inputType' => 'text',
            'eval' => array('rgxp' => 'datim', 'datepicker' => true, 'tl_class' => 'w50 wizard'),
            'sql' => "varchar(11) NOT NULL default ''"
        )
    )
);
