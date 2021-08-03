<?php

/*
 * This file is part of the EOffice project.
 *
 * (c) Anthonius Munthi <https://itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace EOffice\Packages\Doctrine\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\Persistence\Mapping\Driver\MappingDriver;
use Doctrine\Persistence\Mapping\Driver\PHPDriver;
use Illuminate\Config\Repository as RepositoryConfig;
class MetadataConfigurator
{
    /**
     * @var RepositoryConfig
     */
    private $repository;

    public function __construct(RepositoryConfig $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string                 $name
     * @param EntityManagerInterface $manager
     *
     * @throws \Doctrine\ORM\ORMException on ::getMetadataDriverImpl
     *
     * @return void
     */
    public function configure(string $name, EntityManagerInterface $manager): void
    {
        /* @var \LaravelDoctrine\ORM\Extensions\MappingDriverChain $chainDriver */
        $chainDriver = $manager->getConfiguration()->getMetadataDriverImpl();
        $config      = $this->repository;
        $configKey   = 'doctrine.managers.'.$name.'.mappings';
        $settings    = $config->get($configKey, []);

        foreach ($settings as $namespace => $setting) {
            $type          = $setting['type'] ?? 'annotation';
            $dir           = $setting['dir'];
            $fileExtension = $setting['file_extension'] ?? null;
            $driver        = null;

            if ('annotation' === $type) {
                $path = $setting['dir'];
                $chainDriver->addPaths([$path]);
            } else {
                if ('xml' === $type) {
                    $fileExtension = null === $fileExtension ? SimplifiedXmlDriver::DEFAULT_FILE_EXTENSION : $fileExtension;
                    $driver        = new SimplifiedXmlDriver([$dir => $namespace], $fileExtension);
                } elseif ('yaml' === $type || 'yml' === $type) {
                    $fileExtension = null === $fileExtension ? SimplifiedYamlDriver::DEFAULT_FILE_EXTENSION : $fileExtension;
                    $driver        = new SimplifiedYamlDriver([$dir => $namespace], $fileExtension);
                } elseif ('php' === $type) {
                    $driver = new PHPDriver($dir);
                } else {
                    throw new \InvalidArgumentException(sprintf('Unknown doctrine mapping type "%s"', $type));
                }
                $chainDriver->addDriver($driver, $namespace);
            }
        }
    }
}
