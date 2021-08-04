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

namespace EOffice\Packages\Passport\Tests\Bridge;

use EOffice\Packages\Passport\Bridge\ClientRepository;
use EOffice\Packages\Passport\Contracts\ClientInterface;
use EOffice\Packages\Passport\Contracts\ClientManagerInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ClientRepository
 */
class ClientRepositoryTest extends TestCase
{
    /**
     * @var ClientManagerInterface|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $clientManager;

    private ClientRepository $repository;

    protected function setUp(): void
    {
        $this->clientManager = $this->createMock(ClientManagerInterface::class);
        $this->repository    = new ClientRepository($this->clientManager);
    }

    public function testItShouldRetrieveClientByIdentifier()
    {
        $clientManager = $this->clientManager;
        $entity        = $this->createMock(ClientEntityInterface::class);
        $repository    = $this->repository;
        $id            = 'client-id';

        $clientManager->expects($this->exactly(2))
            ->method('createEntityByIdentifier')
            ->with($id)
            ->willReturnOnConsecutiveCalls(
                null,
                $entity
            );

        $this->assertNull($repository->getClientEntity($id));
        $this->assertSame($entity, $repository->getClientEntity($id));
    }

    /**
     * @param bool   $expected
     * @param string $grantType
     * @param array  $clientAttributes
     * @dataProvider getTestValidateClient
     */
    public function testItShouldShouldValidateClient(
        bool $expected,
        string $grantType='granted',
        array $clientAttributes = []
    ) {
        $clientManager = $this->clientManager;
        $client        = $this->createMock(ClientInterface::class);
        $clientId      = 'client-id';
        $repository    = $this->repository;
        $clientSecret  = crypt('secret', 'salt');

        $clientAttributes = array_merge(
            [
                'firstParty' => false,
                'isPersonalAccessClient' => true,
                'confidential' => false,
                'isPasswordClient' => true,
                'getSecret' => $clientSecret,
            ],
            $clientAttributes
        );

        $client->expects($this->any())
            ->method('getGrants')
            ->willReturn(['granted', 'authorization_code', 'personal_access', 'password', 'client_credentials']);

        $clientManager->expects($this->once())
            ->method('findActive')
            ->with($clientId)
            ->willReturn($client);

        foreach ($clientAttributes as $name => $value) {
            $client->expects($this->any())
                ->method($name)
                ->willReturn($value);
        }

        $method = $expected ? 'assertTrue' : 'assertFalse';
        \call_user_func([$this, $method], $repository->validateClient($clientId, $clientSecret, $grantType));
    }

    public function getTestValidateClient(): array
    {
        return [
            [true],
            [false, 'not-granted'],
            [true, 'authorization_code', ['firstParty' => false]],
            [true, 'personal_access', ['confidential' => true]],
            [true, 'client_credentials', ['confidential' => true]],
            [true, 'password'],
        ];
    }
}
