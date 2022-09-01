<?php

use Duncrow\JobsBundle\Model\JobModel;

$GLOBALS['BE_MOD']['content']['jobs'] = array(
    'tables' => array('tl_job', 'tl_content')
);

$GLOBALS['TL_MODELS']['tl_job'] = JobModel::class;
