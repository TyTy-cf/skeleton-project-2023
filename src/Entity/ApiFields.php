<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ApiFields
{

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 8)]
    private ?string $code = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

}
