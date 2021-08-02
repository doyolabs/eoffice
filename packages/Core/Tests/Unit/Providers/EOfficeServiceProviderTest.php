<?php

namespace EOffice\Core\Tests\Unit\Providers;

use EOffice\Core\Providers\EOfficeServiceProvider;
use EOffice\User\Providers\AuthServiceProvider;
use EOffice\User\Providers\UserServiceProvider;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Foundation\Application;
use PHPUnit\Framework\TestCase;

class EOfficeServiceProviderTest extends TestCase
{
    /**
     * @var EOfficeServiceProvider
     */
    private $eoffice;

    /**
     * @var Application|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $app;

    protected function setUp(): void
    {
        $this->app = $this->createMock(Application::class);
        $this->eoffice = new EOfficeServiceProvider($this->app);
    }


    /**
     * @test
     */
    public function it_should_load_eoffice_required_service_provider()
    {
        $eoffice = $this->eoffice;
        $app = $this->app;

        $app->expects($this->exactly(2))
            ->method('register')
            ->withConsecutive(
                [AuthServiceProvider::class, false],
                [UserServiceProvider::class, false]
            );

        $eoffice->boot();
    }
}
