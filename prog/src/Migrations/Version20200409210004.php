<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200409210004 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Problème sub-program identity nullable';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE program DROP FOREIGN KEY FK_92ED7784FF3ED4A8');
        $this->addSql('DROP INDEX UNIQ_92ED7784FF3ED4A8 ON program');
        $this->addSql('ALTER TABLE program ADD identity VARCHAR(255) DEFAULT NULL, DROP identity_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE program ADD identity_id INT DEFAULT NULL, DROP identity');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED7784FF3ED4A8 FOREIGN KEY (identity_id) REFERENCES identity (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_92ED7784FF3ED4A8 ON program (identity_id)');
    }
}
