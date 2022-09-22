<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['joblist'] = '{title_legend},name,type;{config_legend},jumpToReader,jumpToApplication,numberOfItems,job_language,job_featured,job_order,job_showFilter;{template_legend:hide},job_template,customTpl;{expert_legend},guests,cssID';

$GLOBALS['TL_DCA']['tl_module']['palettes']['jobreader'] = '{title_legend},name,type;{template_legend:hide},job_template,customTpl;{expert_legend},guests,cssID';

$GLOBALS['TL_DCA']['tl_module']['palettes']['jobapplication'] = '{title_legend},name,type;{online_legend:hide},job_application_online;{telephone_legend:hide},job_application_telephone;{meeting_legend:hide},job_application_meeting;{template_legend:hide},customTpl;{expert_legend:hide},guests,cssID';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'] = array_merge(
    $GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'],
    array('job_application_online', 'job_application_telephone', 'job_application_meeting')
);
$GLOBALS['TL_DCA']['tl_module']['subpalettes'] = array_merge(
    $GLOBALS['TL_DCA']['tl_module']['subpalettes'],
    array(
        'job_application_online' => 'job_application_online_title,job_application_online_icon,job_application_online_text,job_application_online_linkTitle,applicationForm',
        'job_application_telephone' => 'job_application_telephone_title,job_application_telephone_icon,job_application_telephone_text,job_application_telephone_linkTitle,jumpToTelephone',
        'job_application_meeting' => 'job_application_meeting_title,job_application_meeting_icon,job_application_meeting_text,job_application_meeting_linkTitle,jumpToMeeting'
    )
);

$GLOBALS['TL_DCA']['tl_module']['palettes']['jobapplicationbanner'] = '{title_legend},name,type;{config_legend},jumpTo,job_applicationBanner_image,job_applicationBanner_linkTitle,job_applicationBanner_fixed;{template_legend:hide},customTpl;{expert_legend},guests,cssID';

$this->loadDataContainer('tl_content');
$this->loadLanguageFile('tl_job');

$GLOBALS['TL_DCA']['tl_module']['fields']['jumpTo']['eval']['tl_class'] = 'clr w50';

$GLOBALS['TL_DCA']['tl_module']['fields']['jumpToReader'] = array(
    'exclude' => true,
    'inputType' => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval' => array('tl_class' => 'w50', 'fieldType' => 'radio', 'mandatory' => true),
    'sql' => "int(10) unsigned NOT NULL default 0",
    'relation' => array('type' => 'hasOne', 'load' => 'lazy')
);
$GLOBALS['TL_DCA']['tl_module']['fields']['jumpToApplication'] = array(
    'exclude' => true,
    'inputType' => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval' => array('tl_class' => 'w50', 'fieldType' => 'radio', 'mandatory' => true),
    'sql' => "int(10) unsigned NOT NULL default 0",
    'relation' => array('type' => 'hasOne', 'load' => 'lazy')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['job_applicationBanner_image'] = array(
    'exclude' => true,
    'inputType' => 'fileTree',
    'eval' => array('fieldType' => 'radio', 'filesOnly' => true, 'extensions' => Contao\Config::get('validImageTypes'), 'mandatory' => false, 'tl_class' => 'clr w50'),
    'sql' => "binary(16) NULL"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['job_applicationBanner_linkTitle'] = array(
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class' => 'w50', 'mandatory' => false),
    'sql' => "varchar(255) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_module']['fields']['job_applicationBanner_fixed'] = array(
    'inputType' => 'checkbox',
    'eval' => array('tl_class' => 'm12 w50', 'mandatory' => false),
    'sql' => "char(1) NOT NULL default '1'",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['job_application_online'] = array(
    'inputType' => 'checkbox',
    'eval' => array('tl_class' => 'clr w50', 'submitOnChange' => true),
    'sql' => "char(1) NOT NULL default '1'"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['job_application_online_icon'] = array(
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class' => 'w50', 'mandatory' => false),
    'sql' => "varchar(255) NOT NULL default 'user-helmet-safety'",
);
$GLOBALS['TL_DCA']['tl_module']['fields']['job_application_online_title'] = array(
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class' => 'w50', 'mandatory' => true),
    'sql' => "varchar(255) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_module']['fields']['job_application_online_text'] = array(
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => array('tl_class' => 'w50', 'mandatory' => true),
    'sql' => "text NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_module']['fields']['job_application_online_linkTitle'] = array(
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class' => 'w50', 'mandatory' => true),
    'sql' => "varchar(255) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_module']['fields']['applicationForm'] = array(
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => array('tl_content', 'getForms'),
    'eval' => array('mandatory' => true, 'chosen' => true, 'submitOnChange' => true, 'tl_class' => 'w50 wizard'),
    'wizard' => array
    (
        array('tl_content', 'editForm')
    ),
    'sql' => "int(10) unsigned NOT NULL default 0"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['job_application_telephone'] = array(
    'inputType' => 'checkbox',
    'eval' => array('tl_class' => 'clr w50', 'submitOnChange' => true),
    'sql' => "char(1) NOT NULL default '1'"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['job_application_telephone_icon'] = array(
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class' => 'w50', 'mandatory' => false),
    'sql' => "varchar(255) NOT NULL default 'phone'",
);
$GLOBALS['TL_DCA']['tl_module']['fields']['job_application_telephone_title'] = array(
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class' => 'w50', 'mandatory' => true),
    'sql' => "varchar(255) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_module']['fields']['job_application_telephone_text'] = array(
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => array('tl_class' => 'w50', 'mandatory' => true),
    'sql' => "text NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_module']['fields']['job_application_telephone_linkTitle'] = array(
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class' => 'w50', 'mandatory' => true),
    'sql' => "varchar(255) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_module']['fields']['jumpToTelephone'] = array(
    'exclude' => true,
    'inputType' => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval' => array('tl_class' => 'w50', 'fieldType' => 'radio', 'mandatory' => true),
    'sql' => "int(10) unsigned NOT NULL default 0",
    'relation' => array('type' => 'hasOne', 'load' => 'lazy')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['job_application_meeting'] = array(
    'inputType' => 'checkbox',
    'eval' => array('tl_class' => 'clr w50', 'submitOnChange' => true),
    'sql' => "char(1) NOT NULL default '1'"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['job_application_meeting_icon'] = array(
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class' => 'w50', 'mandatory' => false),
    'sql' => "varchar(255) NOT NULL default 'calendar-alt'",
);
$GLOBALS['TL_DCA']['tl_module']['fields']['job_application_meeting_title'] = array(
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class' => 'w50', 'mandatory' => true),
    'sql' => "varchar(255) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_module']['fields']['job_application_meeting_text'] = array(
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => array('tl_class' => 'w50', 'mandatory' => true),
    'sql' => "text NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_module']['fields']['job_application_meeting_linkTitle'] = array(
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class' => 'w50', 'mandatory' => true),
    'sql' => "varchar(255) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_module']['fields']['jumpToMeeting'] = array(
    'exclude' => true,
    'inputType' => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval' => array('tl_class' => 'w50', 'fieldType' => 'radio', 'mandatory' => true),
    'sql' => "int(10) unsigned NOT NULL default 0",
    'relation' => array('type' => 'hasOne', 'load' => 'lazy')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['job_language'] = array(
    'exclude' => true,
    'inputType' => 'select',
    'options' => array('de' => 'Deutsch', 'en' => 'English'),
    'eval' => array('mandatory' => true, 'tl_class' => 'w50'),
    'sql' => "varchar(16) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['job_featured'] = array(
    'exclude' => true,
    'inputType' => 'select',
    'options' => array('all_items', 'featured', 'unfeatured', 'featured_first'),
    'reference' => &$GLOBALS['TL_LANG']['tl_module'],
    'eval' => array('tl_class' => 'w50 clr'),
    'sql' => "varchar(16) NOT NULL default 'all_items'"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['job_order'] = array(
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => array('tl_module_job', 'getSortingOptions'),
    'reference' => &$GLOBALS['TL_LANG']['tl_module'],
    'eval' => array('tl_class' => 'w50'),
    'sql' => "varchar(32) NOT NULL default 'order_date_desc'"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['job_template'] = array(
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => static function () {
        return Contao\Controller::getTemplateGroup('job_');
    },
    'eval' => array('includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50'),
    'sql' => "varchar(64) NOT NULL default ''"
);

class tl_module_job extends Contao\Backend
{
    /**
     * Return the sorting options
     *
     * @param Contao\DataContainer $dc
     *
     * @return array
     */
    public function getSortingOptions(Contao\DataContainer $dc): array
    {
        return array('job_order_tstamp_asc', 'job_order_tstamp_desc', 'job_order_title_asc', 'job_order_title_desc', 'job_order_random');
    }
}
