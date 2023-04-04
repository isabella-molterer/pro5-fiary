<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Einsatzart
 *
 * @ORM\Table(name="einsatzart")
 * @ORM\Entity
 */
class Einsatzart
{
    /**
     * @var int
     *
     * @ORM\Column(name="ideinsatzart", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ideinsatzart;

    /**
     * @var string
     *
     * @ORM\Column(name="einsatzart_name", type="string", length=255, nullable=false, options={"comment"="lookup für logbuch.unterkategorie abhängig von logbuch.kategorie=einsatz"})
     */
    private $einsatzartName;

    public function getIdeinsatzart(): ?int
    {
        return $this->ideinsatzart;
    }

    public function getEinsatzartName(): ?string
    {
        return $this->einsatzartName;
    }

    public function setEinsatzartName(string $einsatzartName): self
    {
        $this->einsatzartName = $einsatzartName;
        return $this;
    }
}
