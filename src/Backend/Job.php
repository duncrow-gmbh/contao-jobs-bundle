<?php

namespace Duncrow\JobsBundle\Backend;

use Contao\Backend;
use Contao\DataContainer;
use Contao\Image;
use Contao\StringUtil;
use Contao\System;
use Duncrow\JobsBundle\Model\JobModel;
use Exception;
use Locale;

class Job extends Backend
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

    public function getLinkedJobOptions(DataContainer $dc): array
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
}
