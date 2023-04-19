<?php

namespace Duncrow\JobsBundle\Model;

use Contao\Date;
use Contao\Model;

class JobModel extends Model
{
    protected static $strTable = 'tl_job';

    public static function findPublishedByPids($arrPids, $language, $blnFeatured=null, array $arrOptions=array())
    {
        if (empty($arrPids) || !\is_array($arrPids))
        {
            return null;
        }

        $t = static::$strTable;
        $arrColumns = array("$t.pid IN(" . implode(',', array_map('\intval', $arrPids)) . ")");

        $arrColumns[] = "$t.language='".$language."'";

        if ($blnFeatured === true)
        {
            $arrColumns[] = "$t.featured='1'";
        }
        elseif ($blnFeatured === false)
        {
            $arrColumns[] = "$t.featured=''";
        }

        if (!static::isPreviewMode($arrOptions))
        {
            $time = Date::floorToMinute();
            $arrColumns[] = "$t.published='1' AND ($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'$time')";
        }

        if (!isset($arrOptions['order']))
        {
            $arrOptions['order']  = "$t.sorting ASC";
        }

        return static::findBy($arrColumns, null, $arrOptions);
    }
}
