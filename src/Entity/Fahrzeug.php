<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Fahrzeug
 *
 * @ORM\Table(name="fahrzeug")
 * @ORM\Entity
 */
class Fahrzeug
{
    /**
     * @var int
     *
     * @ORM\Column(name="idfahrzeug", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idfahrzeug;

    /**
     * @var string
     *
     * @ORM\Column(name="fahrzeugart", type="string", length=255, nullable=false)
     */
    private $fahrzeugart;

    /**
     * @var string
     *
     * @ORM\Column(name="fahrzeugbezeichnung", type="string", length=255, nullable=false)
     */
    private $fahrzeugbezeichnung;

    /**
     * @var string|null
     *
     * @ORM\Column(name="gesamtkilometer", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $gesamtkilometer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fahrzeugbesatzung", mappedBy="idfahrzeugFahrzeug", cascade={"persist", "remove"})
     */
    private $besatzung;

    public function __toString() {
        return $this->fahrzeugart;
    }

    public function __construct()
    {
        $this->besatzung = new ArrayCollection();
    }

    /**
     * @return Collection|Fahrzeugbesatzung[]
     */
    public function getBesatzung(): Collection
    {
        return $this->besatzung;
    }

    public function addBesatzung(Fahrzeugbesatzung $besatzungeinzeln): self
    {
        if (!$this->besatzung->contains($besatzungeinzeln)) {
            $this->besatzung[] = $besatzungeinzeln;
            $besatzungeinzeln->setIdfahrzeugFahrzeug($this);
        }

        return $this;
    }

    public function removeBesatzung(Fahrzeugbesatzung $besatzungeinzeln): self
    {
        if ($this->besatzung->contains($besatzungeinzeln)) {
            $this->besatzung->removeElement($besatzungeinzeln);
            // set the owning side to null (unless already changed)
            if ($besatzungeinzeln->getIdfahrzeugFahrzeug() === $this) {
                $besatzungeinzeln->setIdfahrzeugFahrzeug(null);
            }
        }
        return $this;
    }

    public function getIdfahrzeug(): ?int
    {
        return $this->idfahrzeug;
    }

    public function getFahrzeugart(): ?string
    {
        return $this->fahrzeugart;
    }

    public function setFahrzeugart(string $fahrzeugart): self
    {
        $this->fahrzeugart = $fahrzeugart;
        return $this;
    }

    public function getFahrzeugbezeichnung(): ?string
    {
        return $this->fahrzeugbezeichnung;
    }

    public function setFahrzeugbezeichnung(string $fahrzeugbezeichnung): self
    {
        $this->fahrzeugbezeichnung = $fahrzeugbezeichnung;
        return $this;
    }

    public function getGesamtkilometer()
    {
        return $this->gesamtkilometer;
    }

    public function setGesamtkilometer($gesamtkilometer): self
    {
        $this->gesamtkilometer = $gesamtkilometer;
        return $this;
    }
}
