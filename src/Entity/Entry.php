<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Entity
 *
 * @ORM\Table(name="logbuch_test")
 * @ORM\Entity
 */
class Entry
{
    /**
     * @ORM\Id
     * @ORM\Column(name="idlogbuch", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idlogbuch;

    /**
     *
     * @ORM\ManyToOne(targetEntity="kategorie")
     * @ORM\JoinColumn(name="idcategory", referencedColumnName="kategorie_id")
     */
    private $kategorie_id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="unterkategorie")
     * @ORM\JoinColumn(name="ideinsatzart", referencedColumnName="unterkategorie_id")
     */
    private $unterkategorie;

    /**
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="beschreibung", type="text")
     */
    private $beschreibung;

    /**
     * @Assert\DateTime
     *
     * @ORM\Column(name="alarmzeit", type="datetime")
     */
    private $alarmzeit;

    /**
     * @Assert\Length(min="3", max="255")
     * @ORM\Column(name="anforderer_name", type="string", nullable=TRUE)
     */
    private $anforderer_name;

    /**
     *
     * @Assert\Regex(
     *     pattern="/^(0|\+)[0-9]/",
     *     message="Please enter a valid phone number"
     * )
     * @ORM\Column(name="anforderer_telefon_nr", type="integer", nullable=TRUE)
     */
    private $anforderer_telefon_nr;

    /**
     * @Assert\Date
     *
     * @ORM\Column(name="beginn_datum")
     */
    private $beginn_datum;

    /**
     * @Assert\Time
     *
     * @ORM\Column(name="beginn_zeit")
     */
    private $beginn_zeit;

    /**
     * @Assert\Date
     *
     * @ORM\Column(name="ende_datum")
     */
    private $ende_datum;

    /**
     * @Assert\Time
     *
     * @ORM\Column(name="ende_zeit")
     */
    private $ende_zeit;

    /**
     *
     * @Assert\Length(
     *     min=4,
     *     max=4,
     *     exactMessage="This value should have exactly {{ limit }} characters.")
     *
     * @ORM\Column(name="plz", type="integer")
     */
    private $plz;

    /**
     *
     * @Assert\Length(min="2", max="255")
     * @ORM\Column(name="ort", type="string")
     */
    private $ort;

    /**
     * @var string
     * @Assert\Length(min="3", max="600")
     * @ORM\Column(name="straße", type="string")
     */
    private $straße;

    /**
     *
     * @Assert\Length(max="255")
     * @ORM\Column(name="hausnummer", type="string")
     */
    private $hausnummer;

    /**
     * @Assert\Length(min="1", max="255")
     * @ORM\Column(name="betriebsmittel", type="string", nullable=TRUE)
     */
    private $betriebsmittel;

    /**
     *
     *
     * @ORM\Column(name="bericht", type="text", nullable=TRUE)
     */
    private $bericht;

    /**
     *
     * @ORM\Column(name="wetter", type="array", nullable=TRUE)
     */
    private $wetter;

    /**
     *
     * @ORM\Column(name="bodenbeschaffenheit", type="array", nullable=TRUE)
     */
    private $bodenbeschaffenheit;

    /**
     *
     * @ORM\Column(name="notizen", type="text", nullable=TRUE)
     */
    private $notizen;

    /**
     * @var int
     *
     * @ORM\Column(name="idbenutzer_benutzer")
     *
     */
    private $idbenutzer;

    /**
     * @Assert\DateTime
     *
     * @ORM\Column(name="metadata", type="datetime")
     */
    private $metaData; //current datetime, when entry is entered

    /**
     * @Assert\Image()
     */
    private $headshot;

    public function setHeadshot(File $file = null)
    {
        $this->headshot = $file;
    }

    public function getHeadshot()
    {
        return $this->headshot;
    }

    public function getIdlogbuch(): ?int
    {
        return $this->idlogbuch;
    }

    public function getBeschreibung(): ?string
    {
        return $this->beschreibung;
    }

    public function setBeschreibung(string $beschreibung): self
    {
        $this->beschreibung = $beschreibung;
        return $this;
    }

    public function getAlarmzeit(): ?\DateTimeInterface
    {
        return $this->alarmzeit;
    }

    public function setAlarmzeit(\DateTimeInterface $alarmzeit): self
    {
        $this->alarmzeit = $alarmzeit;
        return $this;
    }

    public function getAnfordererName(): ?string
    {
        return $this->anforderer_name;
    }

    public function setAnfordererName(?string $anforderer_name): self
    {
        $this->anforderer_name = $anforderer_name;
        return $this;
    }

    public function getAnfordererTelefonNr(): ?int
    {
        return $this->anforderer_telefon_nr;
    }

    public function setAnfordererTelefonNr(?int $anforderer_telefon_nr): self
    {
        $this->anforderer_telefon_nr = $anforderer_telefon_nr;
        return $this;
    }

    public function getBeginnDatum(): ?string
    {
        return $this->beginn_datum;
    }

    public function setBeginnDatum(string $beginn_datum): self
    {
        $this->beginn_datum = $beginn_datum;
        return $this;
    }

    public function getBeginnZeit(): ?string
    {
        return $this->beginn_zeit;
    }

    public function setBeginnZeit(string $beginn_zeit): self
    {
        $this->beginn_zeit = $beginn_zeit;
        return $this;
    }

    public function getEndeDatum(): ?string
    {
        return $this->ende_datum;
    }

    public function setEndeDatum(string $ende_datum): self
    {
        $this->ende_datum = $ende_datum;
        return $this;
    }

    public function getEndeZeit(): ?string
    {
        return $this->ende_zeit;
    }

    public function setEndeZeit(string $ende_zeit): self
    {
        $this->ende_zeit = $ende_zeit;
        return $this;
    }

    public function getPlz(): ?int
    {
        return $this->plz;
    }

    public function setPlz(int $plz): self
    {
        $this->plz = $plz;
        return $this;
    }

    public function getOrt(): ?string
    {
        return $this->ort;
    }

    public function setOrt(string $ort): self
    {
        $this->ort = $ort;
        return $this;
    }

    public function getStraße(): ?string
    {
        return $this->straße;
    }

    public function setStraße(string $straße): self
    {
        $this->straße = $straße;

        return $this;
    }

    public function getHausnummer(): ?string
    {
        return $this->hausnummer;
    }

    public function setHausnummer(string $hausnummer): self
    {
        $this->hausnummer = $hausnummer;

        return $this;
    }

    public function getBetriebsmittel(): ?string
    {
        return $this->betriebsmittel;
    }

    public function setBetriebsmittel(?string $betriebsmittel): self
    {
        $this->betriebsmittel = $betriebsmittel;

        return $this;
    }

    public function getBericht(): ?string
    {
        return $this->bericht;
    }

    public function setBericht(?string $bericht): self
    {
        $this->bericht = $bericht;

        return $this;
    }

    public function getWetter(): ?array
    {
        return $this->wetter;
    }

    public function setWetter(?array $wetter): self
    {
        $this->wetter = $wetter;

        return $this;
    }

    public function getBodenbeschaffenheit(): ?array
    {
        return $this->bodenbeschaffenheit;
    }

    public function setBodenbeschaffenheit(?array $bodenbeschaffenheit): self
    {
        $this->bodenbeschaffenheit = $bodenbeschaffenheit;

        return $this;
    }

    public function getNotizen(): ?string
    {
        return $this->notizen;
    }

    public function setNotizen(?string $notizen): self
    {
        $this->notizen = $notizen;

        return $this;
    }

    public function getIdbenutzer(): ?string
    {
        return $this->idbenutzer;
    }

    public function setIdbenutzer(string $idbenutzer): self
    {
        $this->idbenutzer = $idbenutzer;

        return $this;
    }

    public function getMetaData(): ?\DateTimeInterface
    {
        return $this->metaData;
    }

    public function setMetaData(\DateTimeInterface $metaData): self
    {
        $this->metaData = $metaData;

        return $this;
    }

    public function getKategorieId(): ?kategorie
    {
        return $this->kategorie_id;
    }

    public function setKategorieId(?kategorie $kategorie_id): self
    {
        $this->kategorie_id = $kategorie_id;

        return $this;
    }

    public function getUnterkategorie(): ?unterkategorie
    {
        return $this->unterkategorie;
    }

    public function setUnterkategorie(?unterkategorie $unterkategorie): self
    {
        $this->unterkategorie = $unterkategorie;

        return $this;
    }





}





