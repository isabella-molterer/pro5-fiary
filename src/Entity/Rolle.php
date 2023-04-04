<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Rolle
 *
 * @ORM\Table(name="rolle")
 * @ORM\Entity
 */
class Rolle
{
    /**
     * @var int
     *
     * @ORM\Column(name="idrolle", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idrolle;

    /**
     * @var string
     *
     * @ORM\Column(name="rollenname", type="string", length=255, nullable=false, options={"comment"="lookup für fahrzeugbesatzung.rolle"})
     */
    private $rollenname;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fahrzeugbesatzung", mappedBy="rolle", cascade={"persist", "remove"})
     */
    private $besatzung;

    public function __toString() {
        return $this->rollenname;
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
            $besatzungeinzeln->setRolle($this);
        }
        return $this;
    }

    public function removeBesatzung(Fahrzeugbesatzung $besatzungeinzeln): self
    {
        if ($this->besatzung->contains($besatzungeinzeln)) {
            $this->besatzung->removeElement($besatzungeinzeln);
            // set the owning side to null (unless already changed)
            if ($besatzungeinzeln->getRolle() === $this) {
                $besatzungeinzeln->setRolle(null);
            }
        }
        return $this;
    }

    public function getIdrolle(): ?int
    {
        return $this->idrolle;
    }

    public function getRollenname(): ?string
    {
        return $this->rollenname;
    }

    public function setRollenname(string $rollenname): self
    {
        $this->rollenname = $rollenname;
        return $this;
    }
}
