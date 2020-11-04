<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200329141401 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE program (id INT AUTO_INCREMENT NOT NULL, identity_id INT DEFAULT NULL, name VARCHAR(25) NOT NULL, list_name JSON DEFAULT NULL, UNIQUE INDEX UNIQ_92ED7784FF3ED4A8 (identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program_diapo (program_id INT NOT NULL, diapo_id INT NOT NULL, INDEX IDX_C9F049C73EB8070A (program_id), INDEX IDX_C9F049C7EF92BF59 (diapo_id), PRIMARY KEY(program_id, diapo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program_program (program_source INT NOT NULL, program_target INT NOT NULL, INDEX IDX_19078F50BCA4129 (program_source), INDEX IDX_19078F50122F11A6 (program_target), PRIMARY KEY(program_source, program_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED7784FF3ED4A8 FOREIGN KEY (identity_id) REFERENCES identity (id)');
        $this->addSql('ALTER TABLE program_diapo ADD CONSTRAINT FK_C9F049C73EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_diapo ADD CONSTRAINT FK_C9F049C7EF92BF59 FOREIGN KEY (diapo_id) REFERENCES diapo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_program ADD CONSTRAINT FK_19078F50BCA4129 FOREIGN KEY (program_source) REFERENCES program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_program ADD CONSTRAINT FK_19078F50122F11A6 FOREIGN KEY (program_target) REFERENCES program (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE sous_program');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE program_diapo DROP FOREIGN KEY FK_C9F049C73EB8070A');
        $this->addSql('ALTER TABLE program_program DROP FOREIGN KEY FK_19078F50BCA4129');
        $this->addSql('ALTER TABLE program_program DROP FOREIGN KEY FK_19078F50122F11A6');
        $this->addSql('CREATE TABLE sous_program (id INT AUTO_INCREMENT NOT NULL, identity_id INT NOT NULL, name VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, list_name JSON DEFAULT NULL, UNIQUE INDEX UNIQ_B1E40FC9FF3ED4A8 (identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sous_program ADD CONSTRAINT FK_B1E40FC9FF3ED4A8 FOREIGN KEY (identity_id) REFERENCES identity (id)');
        $this->addSql('DROP TABLE program');
        $this->addSql('DROP TABLE program_diapo');
        $this->addSql('DROP TABLE program_program');
    }
}
