<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Uebungsart
 *
 * @ORM\Table(name="uebungsart")
 * @ORM\Entity
 */
class Uebungsart
{
    /**
     * @var int
     *
     * @ORM\Column(name="iduebungsart", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iduebungsart;

    /**
     * @var string
     *
     * @ORM\Column(name="uebungsname", type="string", length=255, nullable=false, options={"comment"="lookup für logbuch.unterkategorie abhängig von logbuch.kategorie=übung"})
     */
    private $uebungsname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="gesamtzeit", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $gesamtzeit;

    public function getIduebungsart(): ?int
    {
        return $this->iduebungsart;
    }

    public function getUebungsname(): ?string
    {
        return $this->uebungsname;
    }

    public function setUebungsname(string $uebungsname): self
    {
        $this->uebungsname = $uebungsname;
        return $this;
    }

    public function getGesamtzeit()
    {
        return $this->gesamtzeit;
    }

    public function setGesamtzeit($gesamtzeit): self
    {
        $this->gesamtzeit = $gesamtzeit;
        return $this;
    }
}
