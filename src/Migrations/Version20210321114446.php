<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210321114446 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE stockage (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, forme VARCHAR(255) DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, electronique TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE hobby_heidi');
        $this->addSql('ALTER TABLE article ADD stockage_id INT DEFAULT NULL, ADD url LONGTEXT DEFAULT NULL, ADD code_bar_number INT DEFAULT NULL, ADD code_bar_text VARCHAR(255) DEFAULT NULL, ADD type_code_bar INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66DAA83D7F FOREIGN KEY (stockage_id) REFERENCES stockage (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66DAA83D7F ON article (stockage_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66DAA83D7F');
        $this->addSql('CREATE TABLE hobby_heidi (C1 TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE stockage');
        $this->addSql('DROP INDEX IDX_23A0E66DAA83D7F ON article');
        $this->addSql('ALTER TABLE article DROP stockage_id, DROP url, DROP code_bar_number, DROP code_bar_text, DROP type_code_bar');
    }
}
