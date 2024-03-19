<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240319160440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste_collaborative_utilisateur DROP FOREIGN KEY FK_4DCD4AE5112DF681');
        $this->addSql('ALTER TABLE liste_collaborative_utilisateur DROP FOREIGN KEY FK_4DCD4AE5FB88E14F');
        $this->addSql('DROP TABLE liste_collaborative_utilisateur');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE liste_collaborative_utilisateur (liste_collaborative_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_4DCD4AE5112DF681 (liste_collaborative_id), INDEX IDX_4DCD4AE5FB88E14F (utilisateur_id), PRIMARY KEY(liste_collaborative_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE liste_collaborative_utilisateur ADD CONSTRAINT FK_4DCD4AE5112DF681 FOREIGN KEY (liste_collaborative_id) REFERENCES liste_collaborative (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liste_collaborative_utilisateur ADD CONSTRAINT FK_4DCD4AE5FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
