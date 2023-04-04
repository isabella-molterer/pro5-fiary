<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Haus
 *
 * @ORM\Table(name="haeuserliste")
 * @ORM\Entity
 */
class Haus
{
    /**
     * @var int
     *
     * @ORM\Column(name="idhaus", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idhaus;

    /**
     *
     *
     * @ORM\Column(name="strasse", type="string", nullable=false)
     */
    private $strasse;

    /**
     * 
     *
     * @ORM\Column(name="hausNr", type="string", nullable=false)
     */
    private $hausNr;

    /**
     *
     *
     * @ORM\Column(name="bewohner", type="string", nullable=false)
     */
    private $bewohner;

    public function getIdhaus(): ?int
    {
        return $this->idhaus;
    }

    public function getStrasse(): ?string
    {
        return $this->strasse;
    }

    public function setStrasse(string $strasse): self
    {
        $this->strasse = $strasse;
        return $this;
    }

    public function getHausNr(): ?string
    {
        return $this->hausNr;
    }

    public function setHausNr(string $hausNr): self
    {
        $this->hausNr = $hausNr;
        return $this;
    }

    public function getBewohner(): ?string
    {
        return base64_decode($this->bewohner);
    }

    public function setBewohner(string $bewohner): self
    {
        $this->bewohner = $bewohner;
        return $this;
    }
}
