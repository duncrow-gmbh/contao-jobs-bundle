<?php

use Contao\DataContainer;
use Contao\Image;
use Contao\StringUtil;
use Contao\System;
use Contao\DC_Table;
use Duncrow\JobsBundle\Model\JobLocationModel;
use Duncrow\JobsBundle\Model\JobModel;

$strName = 'tl_job';

$this->loadDataContainer('tl_content');
$this->loadDataContainer('tl_module');

$this->loadLanguageFile('opengraph_fields');
$this->loadDataContainer('opengraph_fields');

$GLOBALS['TL_DCA'][$strName] = array
(
    // Config
    'config' => array
    (
        'dataContainer' => DC_Table::class,
        'ptable' => 'tl_job_archive',
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
            'mode' => DataContainer::MODE_PARENT,
            'fields' => array('sorting'),
            'headerFields' => array('title'),
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
                'attributes' => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm']??'') . '\'))return false;Backend.getScrollOffset()"'
            ),
            'toggle' => array
            (
                'href' => 'act=toggle&amp;field=published',
                'icon' => 'visible.svg',
                'button_callback' => array('tl_job', 'toggleIcon'),
                'showInHeader' => true
            ),
            'feature' => array
            (
                'href' => 'act=toggle&amp;field=featured',
                'icon' => 'featured.svg',
                'button_callback' => array('tl_job', 'featureIcon'),
                'showInHeader' => true
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__' => array(),
        'default' => '
			{general_legend},title,alias,language,linkedJobs,employmentType,location,salary,salaryUnit,validThrough,description, overwriteCurrency;
			{meta_legend},metaTitle,metaDescription;
		    {publish_legend},published,featured,start,stop;
            {expert_settings},expertsettingsBaseSalary;

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
            'foreignKey' => 'tl_job_archive.title',
            'sql' => "int(10) unsigned NOT NULL default 0",
            'relation' => array('type'=>'belongsTo', 'load'=>'lazy')
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
                array('tl_job', 'generateAlias')
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
            'options_callback' => array('tl_job', 'getLinkedJobsOptions'),
            'eval' => array('mandatory' => false, 'multiple' => true, 'chosen' => true, 'includeBlankOption' => true, 'tl_class' => 'w50'),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'employmentType' => array(
            'inputType' => 'select',
            'options' => ($GLOBALS['TL_LANG']['tl_job']['employmentType']['options'] ?? []),
            'eval' => array(
                'mandatory' => false,
                'tl_class' => 'w50',
                'chosen' => true,
                'multiple' => true
            ),
            'sql' => "text NULL"
        ),
        'location' => array(
            'inputType' => 'select',
            'options_callback' => array('tl_job', 'getLocationOptions'),
            'eval' => array(
                'mandatory' => false,
                'includeBlankOption' => true,
                'tl_class' => 'w50',
                'chosen' => true
            ),
            'sql' => "text NULL"
        ),
        'salary' => array(
            'inputType' => 'text',
            'eval' => array(
                'rgxp' => 'natural',
                'mandatory' => false,
                'tl_class' => 'w50'
            ),
            'sql' => 'int(10) default NULL'
        ),
        'salaryUnit' =>  array(
            'inputType' => 'select',
            'options' => ($GLOBALS['TL_LANG']['tl_job']['salaryUnit']['options'] ?? []),
            'eval' => array(
                'mandatory' => false,
                'tl_class' => 'w50',
                'chosen' => true,
                'multiple' => false
            ),
            'default'=>'MONTH',
            'sql' => "text NULL"
        ),
        'description' => array
        (
            'search' => true,
            'inputType' => 'textarea',
            'eval' => array('mandatory' => false, 'rte' => 'tinyMCE', 'tl_class' => 'clr'),
            'sql' => "text NULL"
        ),
        'overwriteCurrency' => array
        (
            'inputType'               => 'text',
            'exclude'                 => true,
            'default'                 => 'EUR',
            'eval'                    => array('tl_class'=>'clr',  'maxlength'=>255),
             'sql' => 'text NULL'
        ),

        'expertsettingsBaseSalary' => array
        (
            'search' => false,
            'inputType' => 'textarea',
            'eval' => array('mandatory' => false, 'preserveTags'=>true, 'class'=>'monospace', 'rte'=>'ace|html', 'tl_class'=>'clr'),
            'sql' => "text NULL"
        ),

        'metaTitle' => array
        (
            'search' => true,
            'inputType' => 'text',
            'eval' => array('mandatory' => false, 'allowHtml' => true, 'maxlength' => 255, 'tl_class' => 'clr w50'),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'metaDescription' => array
        (
            'search' => true,
            'inputType' => 'textarea',
            'eval' => array('mandatory' => false, 'tl_class' => 'w50'),
            'sql' => "text NULL"
        ),
        'validThrough' => array
		(
			'inputType'               => 'text',
			'eval'                    => array('mandatory' => true,'rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
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


# Add opengraph fields
$GLOBALS['TL_DCA']['tl_job']['fields'] = array_merge(
    $GLOBALS['TL_DCA']['tl_job']['fields'],
    $GLOBALS['TL_DCA']['opengraph_fields']['fields']
);

# Add opengraph legends
$GLOBALS['TL_DCA']['tl_job']['palettes']['default'] = str_replace(
    '{publish_legend',
    $GLOBALS['TL_DCA']['opengraph_fields']['palettes']['default'].'{publish_legend',
    $GLOBALS['TL_DCA']['tl_job']['palettes']['default']
);

array_walk(
    $GLOBALS['TL_LANG']['opengraph_fields']['legends'],
    function ($translation, $key) {
        $GLOBALS['TL_LANG']['tl_job'][$key] = $translation;
    }
);

# Restrict available types
$GLOBALS['TL_DCA']['tl_job']['config']['allowedOpenGraphTypes'] = ['website'];

class tl_job extends Contao\Backend
{
    private $strName = 'tl_job';

    public function toggleIcon($row, $href, $label, $title, $icon, $attributes): string
    {
        $href .= '&amp;id=' . $row['id'];

        if (!$row['published'])
        {
            $icon = 'invisible.svg';
        }

        return '<a href="' . $this->addToUrl($href) . '" title="' . StringUtil::specialchars($title) . '" onclick="Backend.getScrollOffset();return AjaxRequest.toggleField(this,true)">' . Image::getHtml($icon, $label, 'data-icon="' . Image::getPath('visible.svg') . '" data-icon-disabled="' . Image::getPath('invisible.svg') . '" data-state="' . ($row['published'] ? 1 : 0) . '"') . '</a> ';
    }

    public function featureIcon($row, $href, $label, $title, $icon, $attributes): string
    {
        $href .= '&amp;id=' . $row['id'];

        if (!$row['featured'])
        {
            $icon = 'featured_.svg';
        }

        return '<a href="' . $this->addToUrl($href) . '" title="' . StringUtil::specialchars($title) . '" onclick="Backend.getScrollOffset();return AjaxRequest.toggleField(this,true)">' . Image::getHtml($icon, $label, 'data-icon="' . Image::getPath('featured.svg') . '" data-icon-disabled="' . Image::getPath('featured_.svg') . '" data-state="' . ($row['featured'] ? 1 : 0) . '"') . '</a> ';
    }

    /**
     * @throws Exception
     */
    public function generateAlias($varValue, DataContainer $dc)
    {
        $aliasExists = function (string $alias) use ($dc): bool {
            return $this->Database->prepare("SELECT id FROM {$this->strName} WHERE alias=? AND id!=?")->execute($alias, $dc->id)->numRows > 0;
        };

        // Generate alias if there is none
        if (!$varValue) {
            $varValue = System::getContainer()->get('contao.slug')->generate($dc->activeRecord->title, $aliasExists);
        } elseif (preg_match('/^[1-9]\d*$/', $varValue)) {
            throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasNumeric'], $varValue));
        } elseif ($aliasExists($varValue)) {
            throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
        }

        return $varValue;
    }

    public function getLinkedJobsOptions(DataContainer $dc): array
    {
        $return = [];
        $jobsWithOtherLanguage = JobModel::findBy(array('language!=?'), array($dc->activeRecord->language));

        if($jobsWithOtherLanguage) {
            while ($jobsWithOtherLanguage->next()) {
                $current = $jobsWithOtherLanguage->current();
                $title = $current->title;
                $return[Locale::getDisplayName($current->language)][$current->id] = "$title [".Locale::getDisplayName($current->language)."]";
            }
        }

        return $return;
    }

    public function getLocationOptions(DataContainer $dc): array
    {
        $arrLocations = array();
        $objLocations = JobLocationModel::findAll();

        if($objLocations){
            while ($objLocations->next()) {
                $arrLocations[$objLocations->id] = "$objLocations->street <span class='tl_gray'>[$objLocations->postal $objLocations->city]</span>";
            }
        }

        return $arrLocations;
    }
}
