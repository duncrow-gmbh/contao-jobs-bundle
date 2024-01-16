<?php

namespace Duncrow\JobsBundle\OpenGraph;

use Contao\Input;
use Contao\System;
use Duncrow\JobsBundle\Model\JobModel;
use Exception;
use numero2\OpenGraph3\OpenGraph3;

class OpenGraphJob
{
    /**
     * @throws Exception
     */
    public static function addModuleData($objModule): void
    {
        $currentAlias = Input::get('auto_item');

        if(!$currentAlias)
            return;

        $arrColumns = array();
        $arrColumns[] = "alias='". $currentAlias ."'";
        $arrColumns[] = "language='". $GLOBALS['TL_LANGUAGE'] ."'";

        $objJob = JobModel::findOneBy($arrColumns, null);

        // Check if the job could get loaded from the database
        if (null === $objJob) {
            return;
        }

        $objPage = System::getContainer()->get('request_stack')->getCurrentRequest()->get('pageModel');

        if(isset($objJob->metaTitle) && $objJob->metaTitle)
            $objPage->pageTitle = $objJob->metaTitle;

        if(isset($objJob->metaDescription) && $objJob->metaDescription)
            $objPage->description = $objJob->metaDescription;

        OpenGraph3::addTagsToPage($objJob);
    }
}
