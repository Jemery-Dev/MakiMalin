<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305132543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_categorie_article (article_id INT NOT NULL, categorie_article_id INT NOT NULL, INDEX IDX_94A2D4397294869C (article_id), INDEX IDX_94A2D439EC5D4C30 (categorie_article_id), PRIMARY KEY(article_id, categorie_article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_article (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, liste_id_id INT NOT NULL, quantite INT DEFAULT NULL, achete TINYINT(1) NOT NULL, INDEX IDX_169E6FB960BF4AF9 (liste_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste_collaborative (id INT AUTO_INCREMENT NOT NULL, liste_id_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_AB46A8D260BF4AF9 (liste_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste_collaborative_utilisateur (liste_collaborative_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_4DCD4AE5112DF681 (liste_collaborative_id), INDEX IDX_4DCD4AE5FB88E14F (utilisateur_id), PRIMARY KEY(liste_collaborative_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste_de_courses (id INT AUTO_INCREMENT NOT NULL, proprietaire_id_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_8757F1596EC1D6E1 (proprietaire_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, motdepasse VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_categorie_article ADD CONSTRAINT FK_94A2D4397294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_categorie_article ADD CONSTRAINT FK_94A2D439EC5D4C30 FOREIGN KEY (categorie_article_id) REFERENCES categorie_article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB960BF4AF9 FOREIGN KEY (liste_id_id) REFERENCES liste_de_courses (id)');
        $this->addSql('ALTER TABLE liste_collaborative ADD CONSTRAINT FK_AB46A8D260BF4AF9 FOREIGN KEY (liste_id_id) REFERENCES liste_de_courses (id)');
        $this->addSql('ALTER TABLE liste_collaborative_utilisateur ADD CONSTRAINT FK_4DCD4AE5112DF681 FOREIGN KEY (liste_collaborative_id) REFERENCES liste_collaborative (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liste_collaborative_utilisateur ADD CONSTRAINT FK_4DCD4AE5FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liste_de_courses ADD CONSTRAINT FK_8757F1596EC1D6E1 FOREIGN KEY (proprietaire_id_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_categorie_article DROP FOREIGN KEY FK_94A2D4397294869C');
        $this->addSql('ALTER TABLE article_categorie_article DROP FOREIGN KEY FK_94A2D439EC5D4C30');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB960BF4AF9');
        $this->addSql('ALTER TABLE liste_collaborative DROP FOREIGN KEY FK_AB46A8D260BF4AF9');
        $this->addSql('ALTER TABLE liste_collaborative_utilisateur DROP FOREIGN KEY FK_4DCD4AE5112DF681');
        $this->addSql('ALTER TABLE liste_collaborative_utilisateur DROP FOREIGN KEY FK_4DCD4AE5FB88E14F');
        $this->addSql('ALTER TABLE liste_de_courses DROP FOREIGN KEY FK_8757F1596EC1D6E1');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_categorie_article');
        $this->addSql('DROP TABLE categorie_article');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE liste_collaborative');
        $this->addSql('DROP TABLE liste_collaborative_utilisateur');
        $this->addSql('DROP TABLE liste_de_courses');
        $this->addSql('DROP TABLE utilisateur');
    }
}
