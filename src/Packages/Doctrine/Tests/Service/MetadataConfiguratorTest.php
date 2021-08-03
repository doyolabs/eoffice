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

namespace EOffice\Packages\Doctrine\Tests\Service;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\Persistence\Mapping\Driver\PHPDriver;
use EOffice\Packages\Doctrine\Service\MetadataConfigurator;
use EOffice\Packages\Doctrine\Tests\TestCase;
use Illuminate\Config\Repository as ConfigRepository;
use LaravelDoctrine\ORM\Extensions\MappingDriverChain;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @covers \EOffice\Packages\Doctrine\Service\MetadataConfigurator
 */
class MetadataConfiguratorTest extends TestCase
{
    /**
     * @var EntityManagerInterface|MockObject
     */
    private $em;

    /**
     * @var ConfigRepository|MockObject
     */
    private $repository;

    /**
     * @var MappingDriverChain|MockObject
     */
    private $chainDriver;

    /**
     * @var Configuration|MockObject
     */
    private $configuration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->em            = $this->createMock(EntityManagerInterface::class);
        $this->repository    = $this->createMock(ConfigRepository::class);
        $this->chainDriver   = $this->createMock(MappingDriverChain::class);
        $this->configuration = $this->createMock(Configuration::class);

        $this->em
            ->method('getConfiguration')
            ->willReturn($this->configuration);

        $this->configuration
            ->method('getMetadataDriverImpl')
            ->willReturn($this->chainDriver);
    }

    public function testConfigureAnnotation()
    {
        $em          = $this->em;
        $repository  = $this->repository;
        $chainDriver = $this->chainDriver;
        $settings    = static::$annotationConfig;

        $repository->expects($this->once())
            ->method('get')
            ->with('doctrine.managers.default.mappings')
            ->willReturn($settings);

        $chainDriver->expects($this->once())
            ->method('addPaths')
            ->with([realpath(__DIR__.'/../Fixtures/Model')]);

        $configurator = new MetadataConfigurator($repository);
        $configurator->configure('default', $em);
    }

    public function testConfigureXML()
    {
        $em          = $this->em;
        $repository  = $this->repository;
        $chainDriver = $this->chainDriver;
        $settings    = static::$xmlConfig;

        $repository->expects($this->once())
            ->method('get')
            ->with('doctrine.managers.default.mappings')
            ->willReturn($settings);

        $chainDriver->expects($this->once())
            ->method('addDriver')
            ->with(
                $this->isInstanceOf(SimplifiedXmlDriver::class),
                'EOffice\\Packages\\Doctrine\\Tests\\Fixtures\\XML'
            );

        $configurator = new MetadataConfigurator($repository);
        $configurator->configure('default', $em);
    }

    public function testConfigureYml()
    {
        $em          = $this->em;
        $repository  = $this->repository;
        $chainDriver = $this->chainDriver;
        $settings    = static::$ymlConfig;

        $repository->expects($this->once())
            ->method('get')
            ->with('doctrine.managers.default.mappings')
            ->willReturn($settings);

        $chainDriver->expects($this->once())
            ->method('addDriver')
            ->with(
                $this->isInstanceOf(SimplifiedYamlDriver::class),
                'EOffice\\Packages\\Doctrine\\Tests\\Fixtures\\YML'
            );

        $configurator = new MetadataConfigurator($repository);
        $configurator->configure('default', $em);
    }

    public function testConfigurePHP()
    {
        $em          = $this->em;
        $repository  = $this->repository;
        $chainDriver = $this->chainDriver;
        $settings    = static::$phpConfig;

        $repository->expects($this->once())
            ->method('get')
            ->with('doctrine.managers.default.mappings')
            ->willReturn($settings);

        $chainDriver->expects($this->once())
            ->method('addDriver')
            ->with(
                $this->isInstanceOf(PHPDriver::class),
                'EOffice\\Packages\\Doctrine\\Tests\\Fixtures\\PHP'
            );

        $configurator = new MetadataConfigurator($repository);
        $configurator->configure('default', $em);
    }

    public function testWithInvalidType()
    {
        $em         = $this->em;
        $repository = $this->repository;
        $settings   = [
            'EOffice\\Packages\\Doctrine\\Tests\\Fixtures\\PHP' => [
                'dir' => realpath(__DIR__.'/../Fixtures/Resources/config'),
                'type' => 'foo',
            ],
        ];

        $repository->expects($this->once())
            ->method('get')
            ->with('doctrine.managers.default.mappings')
            ->willReturn($settings);

        $this->expectException(\InvalidArgumentException::class);
        $configurator = new MetadataConfigurator($repository);
        $configurator->configure('default', $em);
    }
}
