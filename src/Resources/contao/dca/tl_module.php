<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['joblist'] = '{title_legend},name,type;{config_legend},jumpTo,numberOfItems,job_language,job_featured,job_order,job_showFilter;{template_legend:hide},job_template,customTpl;{expert_legend},guests,cssID';
$GLOBALS['TL_DCA']['tl_module']['palettes']['jobreader'] = '{title_legend},name,type;{template_legend:hide},job_template,customTpl;{expert_legend},guests,cssID';

$this->loadLanguageFile('tl_job');

$GLOBALS['TL_DCA']['tl_module']['fields']['job_language'] = array
(
    'exclude' => true,
    'inputType' => 'select',
    'options' => array('de' => 'Deutsch', 'en' => 'English'),
    'eval' => array('mandatory' => true, 'tl_class' => 'w50'),
    'sql' => "varchar(16) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['job_featured'] = array
(
    'exclude' => true,
    'inputType' => 'select',
    'options' => array('all_items', 'featured', 'unfeatured', 'featured_first'),
    'reference' => &$GLOBALS['TL_LANG']['tl_module'],
    'eval' => array('tl_class' => 'w50 clr'),
    'sql' => "varchar(16) NOT NULL default 'all_items'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['job_order'] = array
(
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => array('tl_module_job', 'getSortingOptions'),
    'reference' => &$GLOBALS['TL_LANG']['tl_module'],
    'eval' => array('tl_class' => 'w50'),
    'sql' => "varchar(32) NOT NULL default 'order_date_desc'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['job_template'] = array
(
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback' => static function ()
    {
        return Contao\Controller::getTemplateGroup('job_');
    },
    'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(64) NOT NULL default ''"
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
