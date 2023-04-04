<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Table(name="einsatzart_test")
 * @ORM\Entity
 */
class unterkategorie{
    /**
     * @ORM\Id
     * @ORM\Column(name="idcategory", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $ideinsatzart;

    /**
     *
     * @ORM\Column(name="einsatzart_name", type="string")
     *
     */
    private $einsatzart_name;

    public function getIdeinsatzart(): ?int
    {
        return $this->ideinsatzart;
    }

    public function getEinsatzartName(): ?string
    {
        return $this->einsatzart_name;
    }

    public function setEinsatzartName(string $einsatzart_name): self
    {
        $this->einsatzart_name = $einsatzart_name;
        return $this;
    }
}





