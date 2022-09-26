<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220926123936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE pergunta_prova');
        $this->addSql('ALTER TABLE perguntas ADD prova_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN perguntas.prova_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE perguntas ADD CONSTRAINT FK_EC7ED227272FAB5F FOREIGN KEY (prova_id) REFERENCES provas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_EC7ED227272FAB5F ON perguntas (prova_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE pergunta_prova (pergunta_id UUID NOT NULL, prova_id UUID NOT NULL, PRIMARY KEY(pergunta_id, prova_id))');
        $this->addSql('CREATE INDEX idx_ddebc297272fab5f ON pergunta_prova (prova_id)');
        $this->addSql('CREATE INDEX idx_ddebc2973c763537 ON pergunta_prova (pergunta_id)');
        $this->addSql('COMMENT ON COLUMN pergunta_prova.pergunta_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN pergunta_prova.prova_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE pergunta_prova ADD CONSTRAINT fk_ddebc2973c763537 FOREIGN KEY (pergunta_id) REFERENCES perguntas (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pergunta_prova ADD CONSTRAINT fk_ddebc297272fab5f FOREIGN KEY (prova_id) REFERENCES provas (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE perguntas DROP CONSTRAINT FK_EC7ED227272FAB5F');
        $this->addSql('DROP INDEX IDX_EC7ED227272FAB5F');
        $this->addSql('ALTER TABLE perguntas DROP prova_id');
    }
}
