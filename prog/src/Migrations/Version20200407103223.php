<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200407103223 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'création de LiaisonProgram';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE liaison_program (id INT AUTO_INCREMENT NOT NULL, program_principal_id INT NOT NULL, parent_id INT NOT NULL, name VARCHAR(50) NOT NULL, type SMALLINT NOT NULL, INDEX IDX_C407B2624ED83C9 (program_principal_id), INDEX IDX_C407B262727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liaison_program_diapo (liaison_program_id INT NOT NULL, diapo_id INT NOT NULL, INDEX IDX_F9EB25AD65858323 (liaison_program_id), INDEX IDX_F9EB25ADEF92BF59 (diapo_id), PRIMARY KEY(liaison_program_id, diapo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liaison_program_program (liaison_program_id INT NOT NULL, program_id INT NOT NULL, INDEX IDX_C211111565858323 (liaison_program_id), INDEX IDX_C21111153EB8070A (program_id), PRIMARY KEY(liaison_program_id, program_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE liaison_program ADD CONSTRAINT FK_C407B2624ED83C9 FOREIGN KEY (program_principal_id) REFERENCES program (id)');
        $this->addSql('ALTER TABLE liaison_program ADD CONSTRAINT FK_C407B262727ACA70 FOREIGN KEY (parent_id) REFERENCES program (id)');
        $this->addSql('ALTER TABLE liaison_program_diapo ADD CONSTRAINT FK_F9EB25AD65858323 FOREIGN KEY (liaison_program_id) REFERENCES liaison_program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liaison_program_diapo ADD CONSTRAINT FK_F9EB25ADEF92BF59 FOREIGN KEY (diapo_id) REFERENCES diapo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liaison_program_program ADD CONSTRAINT FK_C211111565858323 FOREIGN KEY (liaison_program_id) REFERENCES liaison_program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liaison_program_program ADD CONSTRAINT FK_C21111153EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE program_diapo');
        $this->addSql('DROP TABLE program_program');
        $this->addSql('ALTER TABLE program DROP name, DROP list_name');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE liaison_program_diapo DROP FOREIGN KEY FK_F9EB25AD65858323');
        $this->addSql('ALTER TABLE liaison_program_program DROP FOREIGN KEY FK_C211111565858323');
        $this->addSql('CREATE TABLE program_diapo (program_id INT NOT NULL, diapo_id INT NOT NULL, INDEX IDX_C9F049C73EB8070A (program_id), INDEX IDX_C9F049C7EF92BF59 (diapo_id), PRIMARY KEY(program_id, diapo_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE program_program (program_source INT NOT NULL, program_target INT NOT NULL, INDEX IDX_19078F50BCA4129 (program_source), INDEX IDX_19078F50122F11A6 (program_target), PRIMARY KEY(program_source, program_target)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE program_diapo ADD CONSTRAINT FK_C9F049C73EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_diapo ADD CONSTRAINT FK_C9F049C7EF92BF59 FOREIGN KEY (diapo_id) REFERENCES diapo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_program ADD CONSTRAINT FK_19078F50122F11A6 FOREIGN KEY (program_target) REFERENCES program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_program ADD CONSTRAINT FK_19078F50BCA4129 FOREIGN KEY (program_source) REFERENCES program (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE liaison_program');
        $this->addSql('DROP TABLE liaison_program_diapo');
        $this->addSql('DROP TABLE liaison_program_program');
        $this->addSql('ALTER TABLE program ADD name VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD list_name JSON DEFAULT NULL');
    }
}
