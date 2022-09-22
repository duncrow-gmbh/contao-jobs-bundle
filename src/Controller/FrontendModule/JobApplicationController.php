<?php

namespace Duncrow\JobsBundle\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\FrontendTemplate;
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
 * @FrontendModule("jobapplication",
 *   category="miscellaneous",
 *   template="mod_jobapplication",
 *   renderer="forward"
 * )
 */
class JobApplicationController extends AbstractFrontendModuleController
{
    private $job;
    private $module;

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

        $this->module = $model;
        $this->job = JobModel::findOneBy($arrColumns, null);

        $template->module = $this->module;
        $template->job = $this->job;

        if(!$this->job)
            throw new PageNotFoundException();

        $this->getPageModel()->pageTitle = $this->getPageModel()->title . ' - ' . $this->job->title;

        if($type = Input::get('type')) {
            $template->application = $this->parseItem($type, $model);
        }

        $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/duncrowgmbhcontaojobs/dist/js/script.js';
        $GLOBALS['TL_CSS'][] = 'bundles/duncrowgmbhcontaojobs/dist/css/style.css';

        return $template->getResponse();
    }

    private function parseItem($type = 'online') {

        /** @var FrontendTemplate|object $objTemplate */
        $objTemplate = new FrontendTemplate("application_$type");
        $objTemplate->templateType = "application_$type";

        $objTemplate->applicationForm = $this->module->applicationForm;
        $objTemplate->job = $this->job;

        return $objTemplate->parse();
    }
}
