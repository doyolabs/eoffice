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

use Doctrine\Common\EventManager;
use Doctrine\ORM\EntityManagerInterface;
use EOffice\Packages\Doctrine\Service\TargetEntityResolver;
use EOffice\Packages\Doctrine\Tests\Fixtures\Contracts\UserInterface;
use EOffice\Packages\Doctrine\Tests\Fixtures\Model\User;
use EOffice\Packages\Doctrine\Tests\TestCase;
use Illuminate\Config\Repository as RepositoryConfig;

/**
 * @covers \EOffice\Packages\Doctrine\Service\TargetEntityResolver
 */
class TargetEntityResolverTest extends TestCase
{
    /**
     * @var RepositoryConfig|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $config;
    private TargetEntityResolver $resolver;

    protected function setUp(): void
    {
        $config   = $this->createMock(RepositoryConfig::class);
        $resolves = [
            UserInterface::class => User::class,
        ];

        $config
            ->expects($this->once())
            ->method('get')
            ->with('doctrine.resolve_target_entities')
            ->willReturn($resolves);

        $this->config   = $config;
        $this->resolver = new TargetEntityResolver($config);
    }

    public function testAddSubscribers()
    {
        $events   = $this->createMock(EventManager::class);
        $em       = $this->createMock(EntityManagerInterface::class);
        $resolver = $this->resolver;

        $events->expects($this->once())
            ->method('addEventSubscriber')
            ->with($resolver);

        $resolver->addSubscribers($events, $em);
    }

    public function testGetFilters()
    {
        $this->assertSame([], $this->resolver->getFilters());
    }
}
