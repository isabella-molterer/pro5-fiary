<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Logbuch
 *
 * @ORM\Table(name="logbuch", indexes={@ORM\Index(name="idbenutzer_benutzer", columns={"idbenutzer_benutzer"})})
 * @ORM\Entity
 */
class Logbuch
{
    const UPLOAD_MAX_FILESIZE = '5000k';
    /**
     * @var int
     *
     * @ORM\Column(name="idlogbuch", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idlogbuch;

    /**
     *
     * @Assert\Image()
     */
    private $photo;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="kategorie", type="string", length=255, nullable=false)
     */
    private $kategorie;

    /**
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="unterkategorie", type="integer",  nullable=false)
     */
    private $unterkategorie;

    /**
     *
     *
     * @ORM\Column(name="unterunterkategorie", type="integer",  nullable=true)
     */
    private $unterunterkategorie;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="beschreibung", type="string", length=255, nullable=false)
     */
    private $beschreibung;

    /**
     * @var string
     *
     * @ORM\Column(name="lagebeimEintreffen", type="string", nullable=true)
     */
    private $lagebeimEintreffen;

    /**
     * @var string
     *
     * @ORM\Column(name="geschaedigterName", type="string", length=255, nullable=true)
     */
    private $geschaedigterName;

    /**
     * @var string
     *
     * @ORM\Column(name="geschaedigterAdresse", type="string", length=255, nullable=true)
     */
    private $geschaedigterAdresse;

    /**
     * @var string
     * @Assert\Regex(
     *     pattern="/^(0|\+)[0-9]/",
     *     message="Bitte eine gültige Telefonnummer eingeben"
     * )
     * @ORM\Column(name="geschaedigterTel", type="string", length=255, nullable=true)
     */
    private $geschaedigterTel;

    /**
     * @var string
     *
     * @ORM\Column(name="geschaedigterKennzeichen", type="string", length=255, nullable=true)
     */
    private $geschaedigterKennzeichen;

    /**
     *
     *
     * @ORM\Column(name="anwesend", type="array", nullable=true)
     */
    private $anwesend;

    /**
     * @var string
     *
     * @ORM\Column(name="brandobjekte", type="string", length=255)
     */
    private $brandobjekte;

    /**
     *
     *
     * @ORM\Column(name="brandausDate", type="date", nullable=true)
     */
    private $brandausDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="brandausTime", type="time", nullable=true)
     */
    private $brandausTime;

    /**
     *
     * @ORM\Column(name="brandwacheStartDate", type="date", nullable=true)
     */
    private $brandwacheStartDate;

    /**
     *
     * @ORM\Column(name="brandwacheStartTime", type="time", nullable=true)
     */
    private $brandwacheStartTime;

    /**
     *
     *
     * @ORM\Column(name="brandwacheEndeDate", type="date", nullable=true)
     */
    private $brandwacheEndeDate;

    /**
     *
     *
     * @ORM\Column(name="brandwacheEndeTime", type="time", nullable=true)
     */
    private $brandwacheEndeTime;

    /**
     *
     *
     * @ORM\Column(name="brandausmass", type="integer",  nullable=true)
     */
    private $brandausmass;

    /**
     * @var string
     *
     * @ORM\Column(name="anlass", type="string", length=255, nullable=true)
     */
    private $anlass;

    /**
     *
     *
     * @ORM\Column(name="alarmzeit", type="time")
     */
    private $alarmzeit;

    /**
     *
     *
     * @ORM\Column(name="alarmdatum", type="date")
     */
    private $alarmdatum;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     * @ORM\Column(name="beginn_datum", type="date", nullable=false)
     */
    private $beginnDatum;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     * @ORM\Column(name="beginn_zeit", type="time", nullable=false)
     */
    private $beginnZeit;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     * @ORM\Column(name="ende_datum", type="date", nullable=false)
     */
    private $endeDatum;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     * @ORM\Column(name="ende_zeit", type="time", nullable=false)
     */
    private $endeZeit;

    /**
     * @var int
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="plz", type="integer", nullable=false)
     */
    private $plz;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="ort", type="string", length=255, nullable=false)
     */
    private $ort;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="strasse", type="string", length=255, nullable=false)
     */
    private $strasse;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="hausnummer", type="string", length=255, nullable=false)
     */
    private $hausnummer;

    /**
     * @var string
     *
     * @ORM\Column(name="betriebsmittel", type="string", length=255, nullable=false)
     */
    private $betriebsmittel;

    /**
     * @var string
     *
     * @ORM\Column(name="bericht", type="text", length=0, nullable=false)
     */
    private $bericht;

    /**
     *
     *
     * @ORM\Column(name="wetter", type="array", length=255, nullable=true)
     *
     */
    private $wetter;

    /**
     * @var string
     *
     * @ORM\Column(name="eingesetzteGeraete", type="string", length=255, nullable=true)
     */
    private $eingesetzteGeraete;

    /**
     * @var string
     *
     * @ORM\Column(name="notizen", type="text", nullable=true)
     */
    private $notizen;

    /**
     * @var string
     *
     * @ORM\Column(name="uebungsleiter", type="text", nullable=true)
     */
    private $uebungsleiter;

    /**
     * @var int
     * @Assert\NotBlank()
     * @ORM\Column(name="idbenutzer_benutzer", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $idbenutzerBenutzer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="metadata", nullable=false)
     */
    private $metadata;

    /*/**
     * @ORM\OneToMany(targetEntity="App\Entity\Fahrzeugbesatzung", mappedBy="idlogbuchLogbuch", cascade={"persist", "remove"})
     */
    private $besatzung;

    public function __toString() {
       return (string)$this->idlogbuch;
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

    public function hasBesatzung() :bool
    {
        if (empty($this->besatzung)) {
            return false;
        }
        return true;
    }

    public function addBesatzung(Fahrzeugbesatzung $besatzungeinzeln): self
    {
        if (!$this->besatzung->contains($besatzungeinzeln)) {
            $this->besatzung[] = $besatzungeinzeln;
            $besatzungeinzeln->setIdlogbuchLogbuch($this);
        }

        return $this;
    }

    public function removeBesatzung(Fahrzeugbesatzung $besatzungeinzeln): self
    {
        if ($this->besatzung->contains($besatzungeinzeln)) {
            $this->besatzung->removeElement($besatzungeinzeln);
            // set the owning side to null (unless already changed)
            if ($besatzungeinzeln->getIdlogbuchLogbuch() === $this) {
                $besatzungeinzeln->setIdlogbuchLogbuch(null);
            }
        }

        return $this;
    }

    public static function getKategorieOptions(){
        return["einsatz", "übung", "tätigkeit"];
    }

    public static function getUnterKategorieOptions_Einsatz(){
        return[
            "Brandeinsatz", 
            "Brandsicherheitswache", 
            "Technischer Einsatz",
            "Atemschutzübung", 
            "Begehung", 
            "Bewerbsübung",
            "Branddienstübung",
            "Chargenschulung",
            "FMD-Schulung",
            "Funkübung",
            "Gesamtübung",
            "Gruppenübung",
            "KHD Übung",
            "Kraftfahrübung",
            "Prüfung AP Atemschutz",
            "Prüfung AP Löscheinsatz",
            "Prüfung AP Technischer Einsatz",
            "Schadstoffübung",
            "Schulung",
            "Sprengdienstübung",
            "Tauchdienstübung",
            "Technische Übung",
            "Vorbereitung AP Atemschutz",
            "Vorbereitung AP Löscheinsatz",
            "Vorbereitung AP Technischer Einsatz",
            "Wasserdienstübung",
            "Zugsübung 1.Zug",
            "Zugsübung 2.Zug",
            "Sonstige Übung",
            "Atemschutz", 
            "Ausbildung", 
            "Beratung der Behörden", 
            "Chargensitzung", 
            "Dienstbesprechung",
            "EDV", 
            "Fahrzeug- und Gerätedienst/Fahrmeister",
            "Fahrzeug- und Gerätedienst/Zeugmeister",
            "Feuerwehrball", 
            "Feuerwehrfest",
            "Feuerwehrmedizinischer Dienst",
            "Inspektion",
            "Kirchgang",
            "Kommandobesprechung",
            "Mitgliederbesprechung",
            "Nachrichtendienst",
            "Öffentlichkeitsarbiet und Dokumentation",
            "Repräsentationen",
            "Schadstoffdienst",
            "Schriftverkehr",
            "Sprengdienst",
            "Strahlenschutzdienst",
            "Tätigkeit im Feuerwehrhaus",
            "Veranstaltungen",
            "Versorgungsdienst",
            "Verwaltungstätigkeiten",
            "Vorbeugender Brandschutz",
            "Vorträge/Schulungen",
            "Wartungsarbeiten",
            "Wasserdienst",
            "Sonstige Tätigkeit"
        ];
    }

    public static function getUnterKategorieOptions_Einsatz3(){
        return[0 => "Brandeinsatz", 1 => "Brandsicherheitswache", 2 => "Technischer Einsatz"];
    }

    public static function getUnterKategorieOptions_Übung(){
        return[
            3 => "Atemschutzübung",
            4 => "Begehung",
            5 => "Bewerbsübung",
            6 => "Branddienstübung",
            7 => "Chargenschulung",
            8 => "FMD-Schulung",
            9 => "Funkübung",
            10 => "Gesamtübung",
            11 => "Gruppenübung",
            12 => "KHD Übung",
            13 => "Kraftfahrübung",
            14 =>  "Prüfung AP Atemschutz",
            15 => "Prüfung AP Löscheinsatz",
            16 => "Prüfung AP Technischer Einsatz",
            17 => "Schadstoffübung",
            18 => "Schulung",
            19 => "Sprengdienstübung",
            20 => "Tauchdienstübung",
            21 => "Technische Übung",
            22 => "Vorbereitung AP Atemschutz",
            23 => "Vorbereitung AP Löscheinsatz",
            24 => "Vorbereitung AP Technischer Einsatz",
            25 => "Wasserdienstübung",
            26 => "Zugsübung 1.Zug",
            27 => "Zugsübung 2.Zug",
            28 => "Sonstige Übung"
        ];
    }

    public static function getUnterKategorieOptions_Tätigkeit(){
        return[
            29 => "Atemschutz",
            30 => "Ausbildung",
            31 => "Beratung der Behörden",
            32 => "Chargensitzung",
            33 => "Dienstbesprechung",
            34 => "EDV",
            35 => "Fahrzeug- und Gerätedienst/Fahrmeister",
            36 => "Fahrzeug- und Gerätedienst/Zeugmeister",
            37 => "Feuerwehrball",
            38 => "Feuerwehrfest",
            39 => "Feuerwehrmedizinischer Dienst",
            40 => "Inspektion",
            41 => "Kirchgang",
            42 => "Kommandobesprechung",
            43 => "Mitgliederbesprechung",
            44 => "Nachrichtendienst",
            45 => "Öffentlichkeitsarbiet und Dokumentation",
            46 => "Repräsentationen",
            47 => "Schadstoffdienst",
            48 => "Schriftverkehr",
            49 => "Sprengdienst",
            50 => "Strahlenschutzdienst",
            51 => "Tätigkeit im Feuerwehrhaus",
            52 => "Veranstaltungen",
            53 => "Versorgungsdienst",
            54 => "Verwaltungstätigkeiten",
            55 => "Vorbeugender Brandschutz",
            56 => "Vorträge/Schulungen",
            57 => "Wartungsarbeiten",
            58 => "Wasserdienst",
            59 => "Sonstige Tätigkeit"
        ];
    }

    public static function getUnterKategorien_TechEinsatz(){
        return["Auslaufen von Öl bzw. Treibstoff",
                 "Auspumparbeiten",
                 "Einsätze nach VU",
                 "Hochwassereinsatz",
                 "Insekten-, Bienen-, Wespeneinsätze",
                 "Kanalreinigungsarbeiten",
                 "Retten/Befreien von Menschen",
                 "Retten/Befreien von Tieren",
                 "Straßen reinigen",
                 "Sturmeinsatz",
                 "Unfall mit Schadstoffen",
                 "Unwetter",
                 "Wasserversorgung",
                 "Wasserfüllarbeiten",
                 "Sonstige"
                 ];
    }

    public static function getAnwesendePersonen(){
        return [
            'Bezirkshauptmannschaft'=>'Bezirkshauptmannschaft',
            'EVU'=>'EVU',
            'Polizei'=>'Polizei',
            'Straßenverwaltung'=>'Straßenverwaltung',
            'BFKDT/AFKDT'=>'BFKDT/AFKDT',
            'Gemeinde'=>'Gemeinde',
            'Rettung'=>'Rettung',
            'Wasserwerk'=>'Wasserwerk',
            'Sonstige'=>'Sonstige'
        ];
    }

    public static function getBrandausmassOptions(){
        return["Großbrand", "Mittelbrand", "Kleinbrand", "Vor Eintreffen gelöscht", "Sonstige"];
    }

    public static function getWetterOptions(){
        return["Bedeckt", "Glatteis", "Nebel", "Schnee", "Wind/Sturm", "Glätte", "Hagel", "Regen", "Sonne", "Sonstiges"];
    }

    public function getIdlogbuch(): ?int
    {
        return $this->idlogbuch;
    }

    public function getKategorie(): ?string
    {
        return $this->kategorie;
    }

    public function setKategorie(string $kategorie): self
    {
        $this->kategorie = $kategorie;
        return $this;
    }

    public function getUnterkategorie(): ?int
    {
        return $this->unterkategorie;
    }

    public function setUnterkategorie(int $unterkategorie): self
    {
        $this->unterkategorie = $unterkategorie;
        return $this;
    }

    public function getUnterunterkategorie(): ?int
    {
        return $this->unterunterkategorie;
    }

    public function setUnterunterkategorie(int $unterunterkategorie): self
    {
        $this->unterunterkategorie = $unterunterkategorie;
        return $this;
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

    public function getBeginnDatum()
    {
        return $this->beginnDatum;
    }

    public function setBeginnDatum( $beginnDatum)
    {
        $this->beginnDatum = $beginnDatum;
        return $this;
    }

    public function getBeginnZeit()
    {
        return $this->beginnZeit;
    }

    public function setBeginnZeit($beginnZeit): self
    {
        $this->beginnZeit = $beginnZeit;
        return $this;
    }

    public function getEndeDatum()
    {
        return $this->endeDatum;
    }

    public function setEndeDatum( $endeDatum)
    {
        $this->endeDatum = $endeDatum;
        return $this;
    }

    public function getEndeZeit()
    {
        return $this->endeZeit;
    }

    public function setEndeZeit( $endeZeit): self
    {
        $this->endeZeit = $endeZeit;
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

    public function getStrasse(): ?string
    {
        return $this->strasse;
    }

    public function setStrasse(string $strasse): self
    {
        $this->strasse = $strasse;
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

    public function setBetriebsmittel(string $betriebsmittel): self
    {
        $this->betriebsmittel = $betriebsmittel;
        return $this;
    }

    public function getBericht(): ?string
    {
        return $this->bericht;
    }

    public function setBericht(string $bericht): self
    {
        $this->bericht = $bericht;
        return $this;
    }

    public function getWetter()
    {
        return $this->wetter;
    }

    public function setWetter($wetter)
    {
        $this->wetter = $wetter;
        return $this;
    }

    public function getNotizen(): ?string
    {
        return $this->notizen;
    }

    public function setNotizen(string $notizen): self
    {
        $this->notizen = $notizen;
        return $this;
    }

    public function getIdbenutzerBenutzer(): ?int
    {
        return $this->idbenutzerBenutzer;
    }

    public function setIdbenutzerBenutzer(int $idbenutzerBenutzer): self
    {
        $this->idbenutzerBenutzer = $idbenutzerBenutzer;
        return $this;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

    public function setMetadata($metadata): self
    {
        $this->metadata = $metadata;
        return $this;
    }

    public function getBrandobjekte(): ?string
    {
        return $this->brandobjekte;
    }

    public function setBrandobjekte(?string $brandobjekte): self
    {
        $this->brandobjekte = $brandobjekte;
        return $this;
    }

    public function getBrandausmass(): ?int
    {
        return $this->brandausmass;
    }

    public function setBrandausmass(?int $brandausmass): self
    {
        $this->brandausmass = $brandausmass;
        return $this;
    }

    public function getLagebeimEintreffen(): ?string
    {
        return $this->lagebeimEintreffen;
    }

    public function setLagebeimEintreffen(string $lagebeimEintreffen): self
    {
        $this->lagebeimEintreffen = $lagebeimEintreffen;
        return $this;
    }

    public function getGeschaedigterName(): ?string
    {
        return $this->geschaedigterName;
    }

    public function setGeschaedigterName(string $geschaedigterName): self
    {
        $this->geschaedigterName = $geschaedigterName;
        return $this;
    }

    public function getGeschaedigterAdresse(): ?string
    {
        return $this->geschaedigterAdresse;
    }

    public function setGeschaedigterAdresse(?string $geschaedigterAdresse): self
    {
        $this->geschaedigterAdresse = $geschaedigterAdresse;
        return $this;
    }

    public function getGeschaedigterTel(): ?string
    {
        return $this->geschaedigterTel;
    }

    public function setGeschaedigterTel(?string $geschaedigterTel): self
    {
        $this->geschaedigterTel = $geschaedigterTel;
        return $this;
    }

    public function getGeschaedigterKennzeichen(): ?string
    {
        return $this->geschaedigterKennzeichen;
    }

    public function setGeschaedigterKennzeichen(?string $geschaedigterKennzeichen): self
    {
        $this->geschaedigterKennzeichen = $geschaedigterKennzeichen;
        return $this;
    }

    public function getAnwesend()
    {
        return $this->anwesend;
    }

    public function setAnwesend($anwesend)
    {
        $this->anwesend = $anwesend;
        return $this;
    }

    public function getEingesetzteGeraete(): ?string
    {
        return $this->eingesetzteGeraete;
    }

    public function setEingesetzteGeraete(?string $eingesetzteGeraete): self
    {
        $this->eingesetzteGeraete = $eingesetzteGeraete;
        return $this;
    }

    public function getAnlass(): ?string
    {
        return $this->anlass;
    }

    public function setAnlass(?string $anlass): self
    {
        $this->anlass = $anlass;
        return $this;
    }

    public function getBrandausDate(): ?\DateTimeInterface
    {
        return $this->brandausDate;
    }

    public function setBrandausDate(?\DateTimeInterface $brandausDate = null): self
    {
        $this->brandausDate = $brandausDate;
        return $this;
    }

    public function getBrandausTime(): ?\DateTimeInterface
    {
        return $this->brandausTime;
    }

    public function setBrandausTime(?\DateTimeInterface $brandausTime = null): self
    {
        $this->brandausTime = $brandausTime;
        return $this;
    }

    public function getBrandwacheStartDate(): ?\DateTimeInterface
    {
        return $this->brandwacheStartDate;
    }

    public function setBrandwacheStartDate(?\DateTimeInterface $brandwacheStartDate = null): self
    {
        $this->brandwacheStartDate = $brandwacheStartDate;
        return $this;
    }

    public function getBrandwacheStartTime(): ?\DateTimeInterface
    {
        return $this->brandwacheStartTime;
    }

    public function setBrandwacheStartTime(?\DateTimeInterface $brandwacheStartTime = null): self
    {
        $this->brandwacheStartTime = $brandwacheStartTime;
        return $this;
    }

    public function getBrandwacheEndeDate(): ?\DateTimeInterface
    {
        return $this->brandwacheEndeDate;
    }

    public function setBrandwacheEndeDate(?\DateTimeInterface $brandwacheEndeDate = null): self
    {
        $this->brandwacheEndeDate = $brandwacheEndeDate;
        return $this;
    }

    public function getBrandwacheEndeTime(): ?\DateTimeInterface
    {
        return $this->brandwacheEndeTime;
    }

    public function setBrandwacheEndeTime(?\DateTimeInterface $brandwacheEndeTime = null): self
    {
        $this->brandwacheEndeTime = $brandwacheEndeTime;
        return $this;
    }

    public function getAlarmdatum(): ?\DateTimeInterface
    {
        return $this->alarmdatum;
    }

    public function setAlarmdatum(\DateTimeInterface $alarmdatum = null): self
    {
        $this->alarmdatum = $alarmdatum;
        return $this;
    }

    public function getUebungsleiter(): ?string
    {
        return $this->uebungsleiter;
    }

    public function setUebungsleiter(?string $uebungsleiter): self
    {
        $this->uebungsleiter = $uebungsleiter;
        return $this;
    }

    public function getAlarmzeit(): ?\DateTimeInterface
    {
        return $this->alarmzeit;
    }

    public function setAlarmzeit(\DateTimeInterface $alarmzeit = null): self
    {
        $this->alarmzeit = $alarmzeit;
        return $this;
    }

    public function getPhotoDataBase64Encoded() {
        return base64_encode(file_get_contents($this->photo->getPathname()));
    }

    public function getPhotoMimeType() {
        return $this->photo->getMimeType();
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;
        return $this;
    }
}
