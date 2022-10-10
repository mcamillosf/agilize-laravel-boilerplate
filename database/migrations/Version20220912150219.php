<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220912150219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE materias DROP CONSTRAINT fk_f1b67860272fab5f');
        $this->addSql('DROP INDEX uniq_f1b67860272fab5f');
        $this->addSql('ALTER TABLE materias DROP prova_id');
        $this->addSql('ALTER TABLE provas ADD materium_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN provas.materium_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE provas ADD CONSTRAINT FK_BF21961ACED4FA48 FOREIGN KEY (materium_id) REFERENCES materias (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_BF21961ACED4FA48 ON provas (materium_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE provas DROP CONSTRAINT FK_BF21961ACED4FA48');
        $this->addSql('DROP INDEX IDX_BF21961ACED4FA48');
        $this->addSql('ALTER TABLE provas DROP materium_id');
        $this->addSql('ALTER TABLE materias ADD prova_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN materias.prova_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE materias ADD CONSTRAINT fk_f1b67860272fab5f FOREIGN KEY (prova_id) REFERENCES provas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_f1b67860272fab5f ON materias (prova_id)');
    }
}
