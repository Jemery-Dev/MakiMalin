<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240326154330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE liste_collaborative (id INT AUTO_INCREMENT NOT NULL, liste_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_AB46A8D2E85441D8 (liste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_liste_collaborative (utilisateur_id INT NOT NULL, liste_collaborative_id INT NOT NULL, INDEX IDX_16377402FB88E14F (utilisateur_id), INDEX IDX_16377402112DF681 (liste_collaborative_id), PRIMARY KEY(utilisateur_id, liste_collaborative_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE liste_collaborative ADD CONSTRAINT FK_AB46A8D2E85441D8 FOREIGN KEY (liste_id) REFERENCES liste_de_courses (id)');
        $this->addSql('ALTER TABLE utilisateur_liste_collaborative ADD CONSTRAINT FK_16377402FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_liste_collaborative ADD CONSTRAINT FK_16377402112DF681 FOREIGN KEY (liste_collaborative_id) REFERENCES liste_collaborative (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste_collaborative DROP FOREIGN KEY FK_AB46A8D2E85441D8');
        $this->addSql('ALTER TABLE utilisateur_liste_collaborative DROP FOREIGN KEY FK_16377402FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_liste_collaborative DROP FOREIGN KEY FK_16377402112DF681');
        $this->addSql('DROP TABLE liste_collaborative');
        $this->addSql('DROP TABLE utilisateur_liste_collaborative');
    }
}
