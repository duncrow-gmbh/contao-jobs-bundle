<?php

namespace Duncrow\JobsBundle\Backend;

use Contao\Backend;
use Contao\DataContainer;
use Contao\Image;
use Contao\Input;
use Contao\System;
use Duncrow\JobsBundle\Model\JobModel;
use Exception;
use Locale;

class Job extends Backend
{
    private $strName = 'tl_job';

    public function btnToggle($row, $href, $label, $title, $icon, $attributes): string
    {
        if (strlen(Input::get('tid'))) {
            $this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
            $this->redirect($this->getReferer());
        }

        $href .= '&amp;tid=' . $row['id'] . '&amp;state=' . ($row['published'] ? '' : 1);

        if (!$row['published']) {
            $icon = 'invisible.gif';
        }

        return '<a href="' . $this->addToUrl($href) . '" title="' . specialchars($title) . '"' . $attributes . '>' . Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"') . '</a> ';
    }

    public function featureToggle($row, $href, $label, $title, $icon, $attributes): string
    {
        if (strlen(Input::get('tid'))) {
            $this->toggleFeatured(Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
            $this->redirect($this->getReferer());
        }

        $href .= '&amp;tid=' . $row['id'] . '&amp;state=' . ($row['featured'] ? '' : 1);

        if (!$row['featured']) {
            $icon = 'featured_.svg';
        }

        return '<a href="' . $this->addToUrl($href) . '" title="' . specialchars($title) . '"' . $attributes . '>' . Image::getHtml($icon, $label, 'data-state="' . ($row['featured'] ? 1 : 0) . '"') . '</a> ';
    }

    public function toggleVisibility($intId, $blnVisible, DataContainer $dc = null)
    {
        // Set the ID and action
        Input::setGet('id', $intId);
        Input::setGet('act', 'toggle');

        if ($dc) {
            $dc->id = $intId; // see #8043
        }

        // Update the database
        $this->Database->prepare("UPDATE {$this->strName} SET tstamp=" . time() . ", published='" . ($blnVisible ? '1' : '') . "' WHERE id=?")
            ->execute($intId);
    }

    public function toggleFeatured($intId, $blnVisible, DataContainer $dc = null)
    {
        // Set the ID and action
        Input::setGet('id', $intId);
        Input::setGet('act', 'toggle');

        if ($dc) {
            $dc->id = $intId; // see #8043
        }

        // Update the database
        $this->Database->prepare("UPDATE {$this->strName} SET tstamp=" . time() . ", featured='" . ($blnVisible ? '1' : '') . "' WHERE id=?")
            ->execute($intId);
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
