<?php

namespace EOffice\Packages\Core\Model;

use Doctrine\ORM\Mapping as ORM;

trait ResourceTrait
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected ?string $id;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }
}
