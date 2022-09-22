<?php

namespace Duncrow\JobsBundle\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\Input;
use Duncrow\JobsBundle\Model\JobModel;

/**
 * @Hook("replaceInsertTags")
 */
class ReplaceInsertTagsListener
{
    public function __invoke(string $insertTag, bool $useCache, string $cachedValue, array $flags, array $tags, array $cache, int $_rit, int $_cnt)
    {
        $arrSplit = explode('::', $insertTag);

        if($arrSplit[0] != 'contaojobsbundle')
            return false;

        if($arrSplit[1] == 'job') {
            if($arrSplit[2] == 'this')
                return JobModel::findByIdOrAlias(Input::get('auto_item'))->{$arrSplit[3]};

            return JobModel::findByIdOrAlias($arrSplit[2])->{$arrSplit[3]};
        }
    }
}
