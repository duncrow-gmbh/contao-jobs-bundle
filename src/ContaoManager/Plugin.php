<?php

namespace Duncrow\JobsBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ConfigPluginInterface;
use Duncrow\JobsBundle\DuncrowGmbHContaoJobsBundle;
use Exception;
use Symfony\Component\Config\Loader\LoaderInterface;

class Plugin implements BundlePluginInterface, ConfigPluginInterface
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

    /**
     * Allows a plugin to load container configuration.
     * @param LoaderInterface $loader
     * @param array $managerConfig
     * @throws Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader, array $managerConfig)
    {
        $loader->load('@DuncrowGmbHContaoJobsBundle/Resources/config/config.yml');
        $loader->load('@DuncrowGmbHContaoJobsBundle/Resources/config/routing.yml');
        $loader->load('@DuncrowGmbHContaoJobsBundle/Resources/config/services.yml');
    }
}
