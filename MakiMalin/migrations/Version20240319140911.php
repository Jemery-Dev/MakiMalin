<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240319140911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste_de_courses DROP FOREIGN KEY FK_8757F1596EC1D6E1');
        $this->addSql('DROP INDEX IDX_8757F1596EC1D6E1 ON liste_de_courses');
        $this->addSql('ALTER TABLE liste_de_courses CHANGE proprietaire_id_id proprietaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE liste_de_courses ADD CONSTRAINT FK_8757F15976C50E4A FOREIGN KEY (proprietaire_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_8757F15976C50E4A ON liste_de_courses (proprietaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste_de_courses DROP FOREIGN KEY FK_8757F15976C50E4A');
        $this->addSql('DROP INDEX IDX_8757F15976C50E4A ON liste_de_courses');
        $this->addSql('ALTER TABLE liste_de_courses CHANGE proprietaire_id proprietaire_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE liste_de_courses ADD CONSTRAINT FK_8757F1596EC1D6E1 FOREIGN KEY (proprietaire_id_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8757F1596EC1D6E1 ON liste_de_courses (proprietaire_id_id)');
    }
}
