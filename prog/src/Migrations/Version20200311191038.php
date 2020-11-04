<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200311191038 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE diapo (id INT AUTO_INCREMENT NOT NULL, auteur_id INT NOT NULL, title VARCHAR(90) NOT NULL, description LONGTEXT NOT NULL, is_public TINYINT(1) NOT NULL, code LONGTEXT DEFAULT NULL, create_at DATETIME NOT NULL, modif_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_57993A3160BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, diapo_id INT NOT NULL, text VARCHAR(429) NOT NULL, INDEX IDX_140AB620EF92BF59 (diapo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE diapo ADD CONSTRAINT FK_57993A3160BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620EF92BF59 FOREIGN KEY (diapo_id) REFERENCES diapo (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620EF92BF59');
        $this->addSql('DROP TABLE diapo');
        $this->addSql('DROP TABLE page');
    }
}
