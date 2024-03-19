<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240319141009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste_collaborative DROP FOREIGN KEY FK_AB46A8D260BF4AF9');
        $this->addSql('DROP INDEX UNIQ_AB46A8D260BF4AF9 ON liste_collaborative');
        $this->addSql('ALTER TABLE liste_collaborative CHANGE liste_id_id liste_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE liste_collaborative ADD CONSTRAINT FK_AB46A8D2E85441D8 FOREIGN KEY (liste_id) REFERENCES liste_de_courses (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AB46A8D2E85441D8 ON liste_collaborative (liste_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste_collaborative DROP FOREIGN KEY FK_AB46A8D2E85441D8');
        $this->addSql('DROP INDEX UNIQ_AB46A8D2E85441D8 ON liste_collaborative');
        $this->addSql('ALTER TABLE liste_collaborative CHANGE liste_id liste_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE liste_collaborative ADD CONSTRAINT FK_AB46A8D260BF4AF9 FOREIGN KEY (liste_id_id) REFERENCES liste_de_courses (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AB46A8D260BF4AF9 ON liste_collaborative (liste_id_id)');
    }
}
