<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305161641 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur_liste_collaborative (utilisateur_id INT NOT NULL, liste_collaborative_id INT NOT NULL, INDEX IDX_16377402FB88E14F (utilisateur_id), INDEX IDX_16377402112DF681 (liste_collaborative_id), PRIMARY KEY(utilisateur_id, liste_collaborative_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur_liste_collaborative ADD CONSTRAINT FK_16377402FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_liste_collaborative ADD CONSTRAINT FK_16377402112DF681 FOREIGN KEY (liste_collaborative_id) REFERENCES liste_collaborative (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liste_de_courses ADD utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE liste_de_courses ADD CONSTRAINT FK_8757F159FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_8757F159FB88E14F ON liste_de_courses (utilisateur_id)');
        $this->addSql('ALTER TABLE utilisateur ADD username VARCHAR(180) NOT NULL, ADD roles JSON NOT NULL, DROP motdepasse, CHANGE pseudo password VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3F85E0677 ON utilisateur (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur_liste_collaborative DROP FOREIGN KEY FK_16377402FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_liste_collaborative DROP FOREIGN KEY FK_16377402112DF681');
        $this->addSql('DROP TABLE utilisateur_liste_collaborative');
        $this->addSql('ALTER TABLE liste_de_courses DROP FOREIGN KEY FK_8757F159FB88E14F');
        $this->addSql('DROP INDEX IDX_8757F159FB88E14F ON liste_de_courses');
        $this->addSql('ALTER TABLE liste_de_courses DROP utilisateur_id');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3F85E0677 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD motdepasse VARCHAR(255) DEFAULT NULL, DROP username, DROP roles, CHANGE password pseudo VARCHAR(255) NOT NULL');
    }
}
