<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200329103647 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE identity (id INT AUTO_INCREMENT NOT NULL, auteur_id INT NOT NULL, title VARCHAR(75) NOT NULL, description LONGTEXT NOT NULL, is_public TINYINT(1) NOT NULL, etat SMALLINT NOT NULL, note SMALLINT DEFAULT NULL, niveau SMALLINT NOT NULL, matiere SMALLINT NOT NULL, create_at DATETIME NOT NULL, modif_at DATETIME DEFAULT NULL, INDEX IDX_6A95E9C460BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_program (id INT AUTO_INCREMENT NOT NULL, identity_id INT NOT NULL, name VARCHAR(25) NOT NULL, list_name JSON DEFAULT NULL, UNIQUE INDEX UNIQ_B1E40FC9FF3ED4A8 (identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE identity ADD CONSTRAINT FK_6A95E9C460BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sous_program ADD CONSTRAINT FK_B1E40FC9FF3ED4A8 FOREIGN KEY (identity_id) REFERENCES identity (id)');
        $this->addSql('ALTER TABLE diapo DROP FOREIGN KEY FK_57993A3160BB6FE6');
        $this->addSql('DROP INDEX IDX_57993A3160BB6FE6 ON diapo');
        $this->addSql('ALTER TABLE diapo DROP title, DROP description, DROP is_public, DROP create_at, DROP modif_at, DROP etat, DROP note, DROP niveau, DROP matiere, CHANGE auteur_id identity_id INT NOT NULL');
        $this->addSql('ALTER TABLE diapo ADD CONSTRAINT FK_57993A31FF3ED4A8 FOREIGN KEY (identity_id) REFERENCES identity (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_57993A31FF3ED4A8 ON diapo (identity_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE diapo DROP FOREIGN KEY FK_57993A31FF3ED4A8');
        $this->addSql('ALTER TABLE sous_program DROP FOREIGN KEY FK_B1E40FC9FF3ED4A8');
        $this->addSql('DROP TABLE identity');
        $this->addSql('DROP TABLE sous_program');
        $this->addSql('DROP INDEX UNIQ_57993A31FF3ED4A8 ON diapo');
        $this->addSql('ALTER TABLE diapo ADD title VARCHAR(90) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD is_public TINYINT(1) NOT NULL, ADD create_at DATETIME NOT NULL, ADD modif_at DATETIME DEFAULT NULL, ADD etat SMALLINT DEFAULT NULL, ADD note SMALLINT DEFAULT NULL, ADD niveau SMALLINT NOT NULL, ADD matiere SMALLINT NOT NULL, CHANGE identity_id auteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE diapo ADD CONSTRAINT FK_57993A3160BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_57993A3160BB6FE6 ON diapo (auteur_id)');
    }
}
