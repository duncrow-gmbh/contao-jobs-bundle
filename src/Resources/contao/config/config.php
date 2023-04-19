<?php

use Duncrow\JobsBundle\Model\JobLocationModel;
use Duncrow\JobsBundle\Model\JobModel;

if(TL_MODE == 'BE') {
    $GLOBALS['TL_CSS'][] = '/bundles/duncrowgmbhcontaojobs/backend.css';
}

Contao\ArrayUtil::arrayInsert($GLOBALS['BE_MOD'], 1, [
    'contao-jobs-bundle' => [
        'jobs' => [
            'tables' => array('tl_job_archive', 'tl_job', 'tl_content')
        ],
        'job_location' => [
            'tables' => array('tl_job_location')
        ],
        'job_settings' => [
            'tables' => array('tl_job_settings')
        ]
    ]
]);

$GLOBALS['TL_MODELS']['tl_job'] = JobModel::class;
$GLOBALS['TL_MODELS']['tl_job_location'] = JobLocationModel::class;

$GLOBALS['TL_OG_MODULES'] = array_merge(
    $GLOBALS['TL_OG_MODULES'],
    array(
        array(
            'jobreader',
            'Duncrow\JobsBundle\Controller\FrontendModule\JobReaderController',
            'Duncrow\JobsBundle\OpenGraph\OpenGraphJob'
        )
    )
);
