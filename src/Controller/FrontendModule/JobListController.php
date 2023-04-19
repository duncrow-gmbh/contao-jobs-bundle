<?php

namespace Duncrow\JobsBundle\Controller\FrontendModule;

use Contao\CoreBundle\ServiceAnnotation\FrontendModule;
use Contao\Date;
use Contao\ModuleModel;
use Contao\Template;
use Duncrow\JobsBundle\Model\JobModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @FrontendModule("joblist",
 *   category="miscellaneous",
 *   template="mod_joblist",
 *   renderer="forward"
 * )
 */
class JobListController extends AbstractJobController
{
    protected function getResponse(Template $template, ModuleModel $model, Request $request): ?Response
    {
        // Handle featured estates
        if ($model->job_featured == 'featured')
        {
            $blnFeatured = true;
        }
        elseif ($model->job_featured == 'unfeatured')
        {
            $blnFeatured = false;
        }
        else
        {
            $blnFeatured = null;
        }

        // Determine sorting
        $t = JobModel::getTable();
        $arrOptions = array();
        $order = "$t.sorting ASC";

        if ($model->job_featured == 'featured_first')
        {
            $order .= "$t.featured DESC, ";
        }

        $limit = null;

        // Maximum number of items
        if ($model->numberOfItems > 0)
        {
            $limit = $model->numberOfItems;
        }

        $arrOptions['order'] = $order;
        $arrOptions['limit'] = (int)$limit;

        $objJobs = JobModel::findPublishedByPids(unserialize($model->job_archives), $model->job_language, $blnFeatured, $arrOptions);

        $template->items = $this->parseItems($objJobs, $model->jumpToReader, $model->jumpToApplication, $model->job_template);

        $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/duncrowgmbhcontaojobs/dist/js/script.js';
        $GLOBALS['TL_CSS'][] = 'bundles/duncrowgmbhcontaojobs/dist/css/style.css';

        return $template->getResponse();
    }
}
