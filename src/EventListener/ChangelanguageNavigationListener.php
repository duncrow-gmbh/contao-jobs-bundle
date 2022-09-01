<?php

namespace Duncrow\JobsBundle\EventListener;


use Contao\Input;
use Duncrow\JobsBundle\Model\JobModel;
use Terminal42\ChangeLanguage\Event\ChangelanguageNavigationEvent;

class ChangelanguageNavigationListener
{
    public function onChangelanguageNavigation (ChangelanguageNavigationEvent $event): void
    {
        // The target root page for current event
        $targetRoot = $event->getNavigationItem()->getRootPage();
        $language = $targetRoot->rootLanguage; // The target language

        // Find your current and new alias from the current URL
        $currentAlias = Input::get('auto_item');
        if(!$currentAlias)
            return;

        $arrColumns = array();
        $arrColumns[] = "alias='". $currentAlias ."'";
        $arrColumns[] = "language='". $GLOBALS['TL_LANGUAGE'] ."'";
        $currentElement = JobModel::findOneBy($arrColumns, null);

        if(!count(unserialize($currentElement->linkedProject)))
            return;

        if($language !== $GLOBALS['TL_LANGUAGE']) {
            foreach(unserialize($currentElement->linkedProject) as $linkedProjectId) {
                $newElement = JobModel::findOneBy(array('id=? and language=?'), array($linkedProjectId, $language), array());
                if($newElement) {
                    $newAlias = $newElement->alias;

                    // Pass the new alias to ChangeLanguage
                    $event->getUrlParameterBag()->setUrlAttribute('items', $newAlias);
                    break;
                }
            }
        }
    }
}
