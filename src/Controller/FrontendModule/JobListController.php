<?php

namespace Duncrow\JobsBundle\Controller\FrontendModule;

use Codefog\TagsBundle\Model\TagModel;
use Contao\CoreBundle\ServiceAnnotation\FrontendModule;
use Contao\Database;
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
        $order = '';

        if ($model->job_featured == 'featured_first')
        {
            $order .= "$t.featured DESC, ";
        }

        switch ($model->job_order)
        {
            case 'job_order_title_asc':
                $order .= "$t.title";
                break;

            case 'job_order_title_desc':
                $order .= "$t.title DESC";
                break;

            case 'job_order_random':
                $order .= "RAND()";
                break;

            case 'job_order_tstamp_asc':
                $order .= "$t.tstamp";
                break;

            case 'job_order_tstamp_desc':
                $order .= "$t.tstamp DESC";
                break;

            default:
                $order .= "$t.title ASC";
        }

        $arrColumns = array();

        if ($blnFeatured === true)
        {
            $arrColumns[] = "$t.featured='1'";
        }
        elseif ($blnFeatured === false)
        {
            $arrColumns[] = "$t.featured=''";
        }

        $arrColumns[] = "$t.language='".$model->job_language."'";

        $limit = null;

        // Maximum number of items
        if ($model->numberOfItems > 0)
        {
            $limit = $model->numberOfItems;
        }

        if (!BE_USER_LOGGED_IN || TL_MODE == 'BE')
        {
            $time = Date::floorToMinute();
            $arrColumns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'" . ($time + 60) . "') AND $t.published='1'";
        }

        $objJobs = JobModel::findBy($arrColumns, null, array('order' => $order, 'limit' => $limit));

        foreach($objJobs as $objJob) {
            $arrTags = array();
            $objTags = Database::getInstance()->prepare("SELECT * FROM tl_cfg_tag_job WHERE job_id=$objJob->id")->execute();
            while($objTags->next()) {
                $objTag = TagModel::findByIdOrAlias($objTags->row()['cfg_tag_id']);
                $allTags[$objTag->alias] = $objTag->name;
                $arrTags[] = $objTag;
            }
            $objJob->tags = $arrTags;
        }

        asort($allTags);
        $template->tags = $allTags;

        $template->items = $this->parseItems($objJobs, $model->jumpTo, $model->job_template);

        $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/duncrowgmbhcontaojobs/dist/js/script.js';
        $GLOBALS['TL_CSS'][] = 'bundles/duncrowgmbhcontaojobs/dist/css/style.css';

        return $template->getResponse();
    }
}
