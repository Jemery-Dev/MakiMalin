<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240326132818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE magasin (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD magasin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6620096AE3 FOREIGN KEY (magasin_id) REFERENCES magasin (id)');
        $this->addSql('CREATE INDEX IDX_23A0E6620096AE3 ON article (magasin_id)');
        $this->addSql('ALTER TABLE course ADD article_id INT NOT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB97294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_169E6FB97294869C ON course (article_id)');
        $this->addSql('ALTER TABLE liste_collaborative DROP FOREIGN KEY FK_AB46A8D260BF4AF9');
        $this->addSql('DROP INDEX UNIQ_AB46A8D260BF4AF9 ON liste_collaborative');
        $this->addSql('ALTER TABLE liste_collaborative CHANGE liste_id_id liste_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE liste_collaborative ADD CONSTRAINT FK_AB46A8D2E85441D8 FOREIGN KEY (liste_id) REFERENCES liste_de_courses (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AB46A8D2E85441D8 ON liste_collaborative (liste_id)');
        $this->addSql('ALTER TABLE liste_de_courses DROP FOREIGN KEY FK_8757F1596EC1D6E1');
        $this->addSql('DROP INDEX IDX_8757F1596EC1D6E1 ON liste_de_courses');
        $this->addSql('ALTER TABLE liste_de_courses DROP proprietaire_id_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6620096AE3');
        $this->addSql('DROP TABLE magasin');
        $this->addSql('DROP INDEX IDX_23A0E6620096AE3 ON article');
        $this->addSql('ALTER TABLE article DROP magasin_id');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB97294869C');
        $this->addSql('DROP INDEX IDX_169E6FB97294869C ON course');
        $this->addSql('ALTER TABLE course DROP article_id');
        $this->addSql('ALTER TABLE liste_collaborative DROP FOREIGN KEY FK_AB46A8D2E85441D8');
        $this->addSql('DROP INDEX UNIQ_AB46A8D2E85441D8 ON liste_collaborative');
        $this->addSql('ALTER TABLE liste_collaborative CHANGE liste_id liste_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE liste_collaborative ADD CONSTRAINT FK_AB46A8D260BF4AF9 FOREIGN KEY (liste_id_id) REFERENCES liste_de_courses (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AB46A8D260BF4AF9 ON liste_collaborative (liste_id_id)');
        $this->addSql('ALTER TABLE liste_de_courses ADD proprietaire_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE liste_de_courses ADD CONSTRAINT FK_8757F1596EC1D6E1 FOREIGN KEY (proprietaire_id_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8757F1596EC1D6E1 ON liste_de_courses (proprietaire_id_id)');
    }
}
