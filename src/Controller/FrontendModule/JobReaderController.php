<?php

namespace Duncrow\JobsBundle\Controller\FrontendModule;

use Contao\ContentModel;
use Duncrow\JobsBundle\Model\JobModel;
use Contao\CoreBundle\Exception\PageNotFoundException;
use Contao\CoreBundle\ServiceAnnotation\FrontendModule;
use Contao\Date;
use Contao\ModuleModel;
use Contao\Template;
use Input;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @FrontendModule("jobreader",
 *   category="miscellaneous",
 *   template="mod_jobreader",
 *   renderer="forward"
 * )
 */
class JobReaderController extends AbstractJobController
{
    protected function getResponse(Template $template, ModuleModel $model, Request $request): ?Response
    {
        $t = JobModel::getTable();

        $arrColumns = array();
        $arrColumns[] = "$t.alias='". Input::get('auto_item') ."'";
        $arrColumns[] = "$t.language='". $GLOBALS['TL_LANGUAGE'] ."'";

        if (!BE_USER_LOGGED_IN || TL_MODE == 'BE')
        {
            $time = Date::floorToMinute();
            $arrColumns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'" . ($time + 60) . "') AND $t.published='1'";
        }

        $objJob = JobModel::findOneBy($arrColumns, null);

        if(!$objJob)
            throw new PageNotFoundException();

        $template->item = $this->parseItem($objJob);

        $this->getPageModel()->pageTitle = $objJob->title;

        $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/duncrowgmbhcontaojobs/dist/js/script.js';
        $GLOBALS['TL_CSS'][] = 'bundles/duncrowgmbhcontaojobs/dist/css/style.css';

        return $template->getResponse();
    }
}
