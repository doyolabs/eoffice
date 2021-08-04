<?php

namespace EOffice\Packages\Passport\Model;

use Doctrine\ORM\Mapping as ORM;
use EOffice\Components\Resource\Contracts\TimestampableInterface;
use EOffice\Components\Resource\Model\TimestampableTrait;
use EOffice\Packages\Core\Model\ResourceTrait;
use EOffice\Packages\Passport\Contracts\ClientInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="oauth_personal_access_clients")
 */
class PersonalAccessClient implements TimestampableInterface
{
    use ResourceTrait;
    use TimestampableTrait;

    /**
     * @ORM\ManyToOne(targetEntity="EOffice\Packages\Passport\Contracts\ClientInterface")
     */
    protected ?ClientInterface $client;
}
