<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181120155225 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE logbuch_test (idlogbuch INT AUTO_INCREMENT NOT NULL, kategorie_id VARCHAR(255) NOT NULL, unterkategorie_id VARCHAR(255) NOT NULL, beschreibung LONGTEXT NOT NULL, alarmzeit DATETIME NOT NULL, anforderer_name VARCHAR(255) DEFAULT NULL, anforderer_telefon_nr INT DEFAULT NULL, beginn_datum VARCHAR(255) NOT NULL, beginn_zeit VARCHAR(255) NOT NULL, ende_datum VARCHAR(255) NOT NULL, ende_zeit VARCHAR(255) NOT NULL, plz INT NOT NULL, ort VARCHAR(255) NOT NULL, straße VARCHAR(255) NOT NULL, hausnummer VARCHAR(255) NOT NULL, betriebsmittel VARCHAR(255) DEFAULT NULL, bericht LONGTEXT DEFAULT NULL, wetter LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', bodenbeschaffenheit LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', notizen LONGTEXT DEFAULT NULL, idbenutzer_benutzer VARCHAR(255) NOT NULL, metadata DATETIME NOT NULL, PRIMARY KEY(idlogbuch)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kategorie_test (idcategory INT AUTO_INCREMENT NOT NULL, category_name VARCHAR(255) NOT NULL, PRIMARY KEY(idcategory)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE einsatzart_test (idcategory INT AUTO_INCREMENT NOT NULL, einsatzart_name VARCHAR(255) NOT NULL, PRIMARY KEY(idcategory)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE einsatzart');
        $this->addSql('DROP TABLE fahrzeug');
        $this->addSql('DROP TABLE fahrzeugbesatzung');
        $this->addSql('DROP TABLE kategorie');
        $this->addSql('DROP TABLE logbuch');
        $this->addSql('DROP TABLE rolle');
        $this->addSql('DROP TABLE uebungsart');
        $this->addSql('ALTER TABLE mitglieder CHANGE idmitglieder idmitglieder INT AUTO_INCREMENT NOT NULL, CHANGE telefon_nr telefon_nr INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE einsatzart (ideinsatzart INT UNSIGNED AUTO_INCREMENT NOT NULL, einsatzart_name VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci COMMENT \'lookup für logbuch.unterkategorie abhängig von logbuch.kategorie=einsatz\', PRIMARY KEY(ideinsatzart)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fahrzeug (idfahrzeug INT UNSIGNED AUTO_INCREMENT NOT NULL, fahrzeugart VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, fahrzeugbezeichnung VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, gesamtkilometer NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(idfahrzeug)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fahrzeugbesatzung (idlogbuch_logbuch INT UNSIGNED NOT NULL, idfahrzeug_fahrzeug INT UNSIGNED NOT NULL, idmitglieder_mitglieder INT UNSIGNED NOT NULL, rolle VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, atemschutz TINYINT(1) DEFAULT NULL, INDEX idlogbuch_logbuch (idlogbuch_logbuch), INDEX idfahrzeug_fahrzeug (idfahrzeug_fahrzeug), INDEX idmitglieder_mitglieder (idmitglieder_mitglieder), PRIMARY KEY(idlogbuch_logbuch, idfahrzeug_fahrzeug, idmitglieder_mitglieder)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kategorie (idcategory INT UNSIGNED AUTO_INCREMENT NOT NULL, category_name VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci COMMENT \'lookup für logbuch.kategorie\', PRIMARY KEY(idcategory)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logbuch (idlogbuch INT NOT NULL, kategorie VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, unterkategorie VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, beschreibung VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, alarmzeit DATETIME NOT NULL, anforderer_name VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, anforderer_telefon_nr VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, beginn_datum DATE NOT NULL, beginn_zeit TIME NOT NULL, ende_datum DATE NOT NULL, ende_zeit TIME NOT NULL, plz INT NOT NULL, ort VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, straße VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, hausnummer VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, betriebsmittel VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, bericht LONGTEXT NOT NULL COLLATE latin1_swedish_ci, wetter VARCHAR(255) DEFAULT NULL COLLATE latin1_swedish_ci, bodenbeschaffenheit VARCHAR(255) DEFAULT NULL COLLATE latin1_swedish_ci, notizen LONGTEXT NOT NULL COLLATE latin1_swedish_ci, idbenutzer_benutzer INT UNSIGNED NOT NULL, metadata DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX idbenutzer_benutzer (idbenutzer_benutzer)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rolle (idrolle INT AUTO_INCREMENT NOT NULL, rollenname VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci COMMENT \'lookup für fahrzeugbesatzung.rolle\', PRIMARY KEY(idrolle)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uebungsart (iduebungsart INT UNSIGNED AUTO_INCREMENT NOT NULL, uebungsname VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci COMMENT \'lookup für logbuch.unterkategorie abhängig von logbuch.kategorie=übung\', gesamtzeit NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(iduebungsart)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE logbuch_test');
        $this->addSql('DROP TABLE kategorie_test');
        $this->addSql('DROP TABLE einsatzart_test');
        $this->addSql('ALTER TABLE mitglieder CHANGE idmitglieder idmitglieder INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE telefon_nr telefon_nr VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci');
    }
}
