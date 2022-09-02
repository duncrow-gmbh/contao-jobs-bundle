<?php

namespace Duncrow\JobsBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Duncrow\JobsBundle\DuncrowGmbHContaoJobsBundle;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(DuncrowGmbHContaoJobsBundle::class)->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
