<?php

namespace Duncrow\JobsBundle\EventListener;

use Contao\Config;
use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\Database;
use Contao\ModuleModel;
use Contao\PageModel;
use Duncrow\JobsBundle\Model\JobModel;

/**
 * @Hook("getSearchablePages")
 */
class GetSearchablePagesListener
{
    public function __invoke(array $pages, string $rootId = null, bool $isSitemap = false, string $language = null): array
    {
        $arrRoot = array();

        if ($rootId > 0) {
            $arrRoot = Database::getInstance()->getChildRecords($rootId, 'tl_page');
        }

        $arrProcessed = array();
        $time = time();

        // get all joblist modules
        $objModule = ModuleModel::findBy('type', 'joblist');

        // walk through each joblist module
        if ($objModule !== null) {

            while ($objModule->next()) {

                // Skip joblist modules without target page
                if (!$objModule->jumpToReader) {
                    continue;
                }

                // Skip joblist modules outside the root nodes
                if (!empty($arrRoot) && !\in_array($objModule->jumpToReader, $arrRoot)) {
                    continue;
                }

                // Get the URL of the jumpToReader page
                if (!isset($arrProcessed[$objModule->jumpToReader])) {
                    $objParent = PageModel::findWithDetails($objModule->jumpToReader);

                    // The target page does not exist
                    if ($objParent === null) {
                        continue;
                    }

                    // The target page has not been published (see #5520)
                    if (!$objParent->published || ($objParent->start && $objParent->start > $time) || ($objParent->stop && $objParent->stop <= $time)) {
                        continue;
                    }

                    if ($isSitemap) {
                        // The target page is protected (see #8416)
                        if ($objParent->protected) {
                            continue;
                        }

                        // The target page is exempt from the sitemap (see #6418)
                        if ($objParent->robots == 'noindex,nofollow') {
                            continue;
                        }
                    }

                    // Generate the URL
                    $arrProcessed[$objModule->jumpToReader] = $objParent->getAbsoluteUrl(Config::get('useAutoItem') ? '/%s' : '/items/%s');
                }

                $strUrl = $arrProcessed[$objModule->jumpToReader];

                // Get the jobs
                $objJob = JobModel::findBy('published', '1');

                if ($objJob !== null) {
                    while ($objJob->next()) {
                        if ($isSitemap && $objJob->robots === 'noindex,nofollow') {
                            continue;
                        }

                        $pages[] = $this->getLink($objJob, $strUrl);
                    }
                }
            }
        }

        return $pages;
    }

    protected function getLink($objItem, $strUrl, $strBase=''): string
    {
        // Backwards compatibility (see #8329)
        if ($strBase && !preg_match('#^https?://#', $strUrl))
        {
            $strUrl = $strBase . $strUrl;
        }

        return sprintf(preg_replace('/%(?!s)/', '%%', $strUrl), ($objItem->alias ?: $objItem->id));
    }
}
