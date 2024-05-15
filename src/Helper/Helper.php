<?php

namespace Duncrow\JobsBundle\Helper;

use Duncrow\JobsBundle\Model\JobLocationModel;

class Helper {

    public static function getStructuredDataForEmploymentType($employmentType): string
    {
        $employmentType = unserialize($employmentType);

        if(is_array($employmentType)){
            return implode(',', array_map(function($a) {
                return '"'.$a.'"';
            }, $employmentType));
        }else{
            return ""; 
        }
        
    }

    public static function getStructuredDataForLocation($locationId): string
    {
        $objJobLocation = JobLocationModel::findBy("id", $locationId);
        if($objJobLocation){
            return sprintf(
                '"@type": "Place", "address": { "@type": "PostalAddress", "streetAddress": "%s", "addressLocality": "%s", "addressRegion": "%s", "postalCode": "%s", "addressCountry": "%s" }',
                ($objJobLocation->street??''),
                ($objJobLocation->city??''),
                ($objJobLocation->region??''),
                ($objJobLocation->postal??''),
                ($objJobLocation->country? strtoupper($objJobLocation->country):'')
            );
        }else{
            return ''; 
        }

        
    }
}
