<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Mitglieder
 *
 * @ORM\Table(name="mitglieder")
 * @ORM\Entity
 */
class Mitglieder
{
    /**
     * @var int
     *
     * @ORM\Column(name="idmitglieder", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idmitglieder;

    /**
     * @var int
     *
     * @ORM\Column(name="standesbuchnummer", type="integer", nullable=false)
     */
    private $standesbuchnummer;

    /**
     * @var string
     *
     * @ORM\Column(name="dienstgrad", type="string", length=255, nullable=false)
     */
    private $dienstgrad;

    /**
     * @var string
     *
     * @ORM\Column(name="vorname", type="string", length=255, nullable=false)
     */
    private $vorname;

    /**
     * @var string
     *
     * @ORM\Column(name="nachname", type="string", length=255, nullable=false)
     */
    private $nachname;

    /**
     * @var string
     *
     * @ORM\Column(name="telefon_nr", type="string", length=255, nullable=true)
     */
    private $telefonNr;

    /**
     * @var string
     *
     * @ORM\Column(name="mobil", type="string", length=255, nullable=true)
     */
    private $mobil;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="atemschutztauglich", type="boolean", nullable=false)
     */
    private $atemschutztauglich;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fahrzeugbesatzung", mappedBy="idmitgliederMitglieder", cascade={"persist", "remove"})
     */
    private $besatzung;

    public function __toString() {
        return $this->vorname. ' '.$this->nachname;
    }

    public function __construct()
    {
        $this->besatzung = new ArrayCollection();

    }

    public function getUniqueName()
    {
        return sprintf('%s - %s - %s', $this->standesbuchnummer, $this->vorname, $this->nachname);
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
            $besatzungeinzeln->setIdmitgliederMitglieder($this);
        }
        return $this;
    }

    public function removeBesatzung(Fahrzeugbesatzung $besatzungeinzeln): self
    {
        if ($this->besatzung->contains($besatzungeinzeln)) {
            $this->besatzung->removeElement($besatzungeinzeln);
            // set the owning side to null (unless already changed)
            if ($besatzungeinzeln->getIdmitgliederMitglieder() === $this) {
                $besatzungeinzeln->setIdmitgliederMitglieder(null);
            }
        }
        return $this;
    }

    public function getIdmitglieder(): ?int
    {
        return $this->idmitglieder;
    }

    public function setIdmiglieder(int $idmitglieder): self
    {
        $this->idmitglieder = $idmitglieder;
        return $this;
    }

    public function getStandesbuchnummer(): ?int
    {
        return $this->standesbuchnummer;
    }

    public function setStandesbuchnummer(int $standesbuchnummer): self
    {
        $this->standesbuchnummer = $standesbuchnummer;
        return $this;
    }

    public function getDienstgrad(): ?string
    {
        return $this->dienstgrad;
    }

    public function setDienstgrad(string $dienstgrad): self
    {
        $this->dienstgrad = $dienstgrad;
        return $this;
    }

    public function getVorname(): ?string
    {
        return $this->vorname;
    }

    public function setVorname(string $vorname): self
    {
        $this->vorname = $vorname;
        return $this;
    }

    public function getNachname(): ?string
    {
        return $this->nachname;
    }

    public function setNachname(string $nachname): self
    {
        $this->nachname = $nachname;
        return $this;
    }

    public function getTelefonNr(): ?string
    {
        return $this->telefonNr;
    }

    public function setTelefonNr(string $telefonNr): self
    {
        $this->telefonNr = $telefonNr;
        return $this;
    }

    public function getMobil(): ?string
    {
        return $this->mobil;
    }

    public function setMobil(string $mobil): self
    {
        $this->mobil = $mobil;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getAtemschutztauglich(): ?bool
    {
        return $this->atemschutztauglich;
    }

    public function setAtemschutztauglich(bool $atemschutztauglich): self
    {
        $this->atemschutztauglich = $atemschutztauglich;
        return $this;
    }
}
