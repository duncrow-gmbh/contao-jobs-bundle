<?php

namespace Duncrow\JobsBundle\Helper;

use Duncrow\JobsBundle\Model\JobLocationModel;

class Helper {

    public static function getStructuredDataForEmploymentType($employmentType): string
    {
        $employmentType = unserialize($employmentType);

        return implode(',', array_map(function($a) {
            return '"'.$a.'"';
        }, $employmentType));
    }

    public static function getStructuredDataForLocation($locationId): string
    {
        $objJobLocation = JobLocationModel::findByIdOrAlias($locationId);

        return sprintf(
            '"@type": "Place", "address": { "@type": "PostalAddress", "streetAddress": "%s", "addressLocality": "%s", "addressRegion": "%s", "postalCode": "%s", "addressCountry": "%s" }',
            $objJobLocation->street,
            $objJobLocation->city,
            $objJobLocation->region,
            $objJobLocation->postal,
            strtoupper($objJobLocation->country)
        );
    }
}
