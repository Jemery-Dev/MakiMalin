<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240401210804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, magasin_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, image VARCHAR(5000) DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_23A0E6620096AE3 (magasin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_categorie_article (article_id INT NOT NULL, categorie_article_id INT NOT NULL, INDEX IDX_94A2D4397294869C (article_id), INDEX IDX_94A2D439EC5D4C30 (categorie_article_id), PRIMARY KEY(article_id, categorie_article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_article (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, liste_id_id INT NOT NULL, article_id INT NOT NULL, quantite INT DEFAULT NULL, achete TINYINT(1) NOT NULL, INDEX IDX_169E6FB960BF4AF9 (liste_id_id), INDEX IDX_169E6FB97294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste_collaborative (id INT AUTO_INCREMENT NOT NULL, liste_de_courses_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_AB46A8D2FD84C423 (liste_de_courses_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste_collaborative_utilisateur (liste_collaborative_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_4DCD4AE5112DF681 (liste_collaborative_id), INDEX IDX_4DCD4AE5FB88E14F (utilisateur_id), PRIMARY KEY(liste_collaborative_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste_de_courses (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_8757F159FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE magasin (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6620096AE3 FOREIGN KEY (magasin_id) REFERENCES magasin (id)');
        $this->addSql('ALTER TABLE article_categorie_article ADD CONSTRAINT FK_94A2D4397294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_categorie_article ADD CONSTRAINT FK_94A2D439EC5D4C30 FOREIGN KEY (categorie_article_id) REFERENCES categorie_article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB960BF4AF9 FOREIGN KEY (liste_id_id) REFERENCES liste_de_courses (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB97294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE liste_collaborative ADD CONSTRAINT FK_AB46A8D2FD84C423 FOREIGN KEY (liste_de_courses_id) REFERENCES liste_de_courses (id)');
        $this->addSql('ALTER TABLE liste_collaborative_utilisateur ADD CONSTRAINT FK_4DCD4AE5112DF681 FOREIGN KEY (liste_collaborative_id) REFERENCES liste_collaborative (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liste_collaborative_utilisateur ADD CONSTRAINT FK_4DCD4AE5FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liste_de_courses ADD CONSTRAINT FK_8757F159FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6620096AE3');
        $this->addSql('ALTER TABLE article_categorie_article DROP FOREIGN KEY FK_94A2D4397294869C');
        $this->addSql('ALTER TABLE article_categorie_article DROP FOREIGN KEY FK_94A2D439EC5D4C30');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB960BF4AF9');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB97294869C');
        $this->addSql('ALTER TABLE liste_collaborative DROP FOREIGN KEY FK_AB46A8D2FD84C423');
        $this->addSql('ALTER TABLE liste_collaborative_utilisateur DROP FOREIGN KEY FK_4DCD4AE5112DF681');
        $this->addSql('ALTER TABLE liste_collaborative_utilisateur DROP FOREIGN KEY FK_4DCD4AE5FB88E14F');
        $this->addSql('ALTER TABLE liste_de_courses DROP FOREIGN KEY FK_8757F159FB88E14F');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_categorie_article');
        $this->addSql('DROP TABLE categorie_article');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE liste_collaborative');
        $this->addSql('DROP TABLE liste_collaborative_utilisateur');
        $this->addSql('DROP TABLE liste_de_courses');
        $this->addSql('DROP TABLE magasin');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
