<?php

namespace Duncrow\JobsBundle\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\FrontendTemplate;
use Contao\PageModel;
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
 * @FrontendModule("jobapplicationbanner",
 *   category="miscellaneous",
 *   template="mod_jobapplication_banner",
 *   renderer="forward"
 * )
 */
class JobApplicationBannerController extends AbstractFrontendModuleController
{
    protected function getResponse(Template $template, ModuleModel $model, Request $request): ?Response
    {
        $template->image = $model->job_applicationBanner_image;
        $template->href = PageModel::findWithDetails($model->jumpTo)->getFrontendUrl();

        if($model->job_applicationBanner_fixed) {
            $template->class .= " fixed";
        }

        $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/duncrowgmbhcontaojobs/dist/js/script.js';
        $GLOBALS['TL_CSS'][] = 'bundles/duncrowgmbhcontaojobs/dist/css/style.css';

        return $template->getResponse();
    }
}
