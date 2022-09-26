<?php

use Duncrow\JobsBundle\Model\JobModel;

if(TL_MODE == 'BE') {
    $GLOBALS['TL_CSS'][] = '/bundles/duncrowgmbhcontaojobs/backend.css';
}

$GLOBALS['BE_MOD']['content']['jobs'] = array(
    'tables' => array('tl_job', 'tl_job_settings', 'tl_content')
);

$GLOBALS['TL_MODELS']['tl_job'] = JobModel::class;

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
