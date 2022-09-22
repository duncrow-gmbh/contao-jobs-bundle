<?php

namespace Duncrow\JobsBundle\Controller\FrontendModule;

use Contao\ContentElement;
use Contao\ContentModel;
use Contao\Controller;
use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\FrontendTemplate;
use Contao\PageModel;
use Contao\System;

abstract class AbstractJobController extends AbstractFrontendModuleController
{
    protected function parseItems($objItems, $jumpToReader, $jumpToApplication, $template = 'job_short'): array
    {
        $arrItems = array();

        if($objItems === null)
            return array();

        while ($objItems->next())
        {
            $objItem = $objItems->current();
            $arrItems[] = $this->parseItem($objItem, $jumpToReader, $jumpToApplication, $template);
        }

        return $arrItems;
    }

    protected function parseItem($objItem, $jumpToReader = null, $jumpToApplication = null, $template = 'job_full')
    {
        if($jumpToReader) {
            $objDetailLink = PageModel::findWithDetails($jumpToReader);
            $objItem->href = $objDetailLink->getFrontendUrl('/' . $objItem->alias);
        }

        if($jumpToApplication) {
            $objDetailLink = PageModel::findWithDetails($jumpToApplication);
            $objItem->hrefApplication = $objDetailLink->getFrontendUrl('/' . $objItem->alias);
        }

        $arrElements = array();
        $objCte = ContentModel::findPublishedByPidAndTable($objItem->id, 'tl_job');

        if ($objCte !== null)
        {
            while ($objCte->next())
            {
                $arrElements[] = $this->getContentElement($objCte->current());
            }
        }

        /** @var FrontendTemplate|object $objTemplate */
        $objTemplate = new FrontendTemplate($template);
        $objTemplate->setData($objItem->row());
        $objTemplate->headTitle = $objItem->title;
        $objTemplate->templateType = $template;

        $objTemplate->elements = $arrElements;

        return $objTemplate->parse();
    }

    /**
     * Generate a content element and return it as string
     *
     * @param mixed  $intId     A content element ID or a Model object
     * @param string $strColumn The column the element is in
     *
     * @return string The content element HTML markup
     */
    protected static function getContentElement($intId, ?string $strColumn='main'): string
    {
        if (\is_object($intId))
        {
            $objRow = $intId;
        }
        else
        {
            if ($intId < 1 || !\strlen($intId))
            {
                return '';
            }

            $objRow = ContentModel::findByPk($intId);

            if ($objRow === null)
            {
                return '';
            }
        }

        // Check the visibility (see #6311)
        if (!Controller::isVisibleElement($objRow))
        {
            return '';
        }

        $strClass = ContentElement::findClass($objRow->type);

        // Return if the class does not exist
        if (!class_exists($strClass))
        {
            System::getContainer()->get('monolog.logger.contao.error')->error('Content element class "' . $strClass . '" (content element "' . $objRow->type . '") does not exist');

            return '';
        }

        $objRow->typePrefix = 'ce_';
        $strStopWatchId = 'contao.content_element.' . $objRow->type . ' (ID ' . $objRow->id . ')';

        if ($objRow->type != 'module' && System::getContainer()->getParameter('kernel.debug'))
        {
            $objStopwatch = System::getContainer()->get('debug.stopwatch');
            $objStopwatch->start($strStopWatchId, 'contao.layout');
        }

        /** @var ContentElement $objElement */
        $objElement = new $strClass($objRow, $strColumn);
        $strBuffer = $objElement->generate();

        // HOOK: add custom logic
        if (isset($GLOBALS['TL_HOOKS']['getContentElement']) && \is_array($GLOBALS['TL_HOOKS']['getContentElement']))
        {
            foreach ($GLOBALS['TL_HOOKS']['getContentElement'] as $callback)
            {
                $strBuffer = System::importStatic($callback[0])->{$callback[1]}($objRow, $strBuffer, $objElement);
            }
        }

        // Disable indexing if protected
        if ($objElement->protected && !preg_match('/^\s*<!-- indexer::stop/', $strBuffer))
        {
            $strBuffer = "\n<!-- indexer::stop -->" . $strBuffer . "<!-- indexer::continue -->\n";
        }

        if (isset($objStopwatch) && $objStopwatch->isStarted($strStopWatchId))
        {
            $objStopwatch->stop($strStopWatchId);
        }

        return $strBuffer;
    }
}
