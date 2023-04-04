<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fahrzeugbesatzung
 *
 * @ORM\Table(name="fahrzeugbesatzung")
 * @ORM\Entity
 */
class Fahrzeugbesatzung
{

    /**
     * @var int
     *
     * @ORM\Column(name="idfahrzeugbesatzung", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idfahrzeugbesatzung;

    /**
     *
     *
     * @ORM\JoinColumn(name="idlogbuch_logbuch", referencedColumnName="idlogbuch", nullable=false)
     * @ORM\ManyToOne(targetEntity="App\Entity\Logbuch", inversedBy="besatzung")
     */
    private $idlogbuchLogbuch;

    /**
     *
     * @ORM\JoinColumn(name="idfahrzeug_fahrzeug", referencedColumnName="idfahrzeug", nullable=false)
     * @ORM\ManyToOne(targetEntity="App\Entity\Fahrzeug", inversedBy="besatzung")
     */
    private $idfahrzeugFahrzeug;

    /**
     *
     *
     * @ORM\JoinColumn(name="idmitglieder_mitglieder", referencedColumnName="idmitglieder",nullable=false)
     * @ORM\ManyToOne(targetEntity="App\Entity\Mitglieder",  inversedBy="besatzung")
     */
    private $idmitgliederMitglieder;

    /**
     *
     * @ORM\JoinColumn(name="rolle", referencedColumnName="idrolle",nullable=false)
     * @ORM\ManyToOne(targetEntity="App\Entity\Rolle",  inversedBy="besatzung")
     */
    private $rolle;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="atemschutz", type="boolean", nullable=true)
     */
    private $atemschutz;

    public function getIdfahrzeugbesatzung(): ?int
    {
        return $this->idfahrzeugbesatzung;
    }

    public function setIdfahrzeugbesatzung(?int $idfahrzeugbesatzung): ?int
    {
        $this->idfahrzeugbesatzung = $idfahrzeugbesatzung;
        return $this->idfahrzeugbesatzung;
    }

    public function getIdlogbuchLogbuch(): ?Logbuch
    {
        return $this->idlogbuchLogbuch;
    }

    public function setIdlogbuchLogbuch(?Logbuch $idlogbuchLogbuch): self
    {
        $this->idlogbuchLogbuch = $idlogbuchLogbuch;

        return $this;
    }

    public function getidfahrzeugFahrzeug(): ?Fahrzeug
    {
        return $this->idfahrzeugFahrzeug;
    }

    public function setIdfahrzeugFahrzeug(?Fahrzeug $idfahrzeugFahrzeug): self
    {
        $this->idfahrzeugFahrzeug = $idfahrzeugFahrzeug;
        return $this;
    }

    public function getIdmitgliederMitglieder(): ?Mitglieder
    {
        return $this->idmitgliederMitglieder;
    }

    public function setIdmitgliederMitglieder(?Mitglieder $idmitgliederMitglieder): self
    {
        $this->idmitgliederMitglieder = $idmitgliederMitglieder;
        return $this;
    }

    public function getRolle(): ?Rolle
    {
        return $this->rolle;
    }

    public function setRolle(Rolle $rolle = null): self
    {
        $this->rolle = $rolle;
        return $this;
    }

    public function getAtemschutz(): ?bool
    {
        return $this->atemschutz;
    }

    public function setAtemschutz(?bool $atemschutz): self
    {
        $this->atemschutz = $atemschutz;
        return $this;
    }
}
