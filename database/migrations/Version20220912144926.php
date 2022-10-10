<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220912144926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pergunta_prova (pergunta_id UUID NOT NULL, prova_id UUID NOT NULL, PRIMARY KEY(pergunta_id, prova_id))');
        $this->addSql('CREATE INDEX IDX_DDEBC2973C763537 ON pergunta_prova (pergunta_id)');
        $this->addSql('CREATE INDEX IDX_DDEBC297272FAB5F ON pergunta_prova (prova_id)');
        $this->addSql('COMMENT ON COLUMN pergunta_prova.pergunta_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN pergunta_prova.prova_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE pergunta_prova ADD CONSTRAINT FK_DDEBC2973C763537 FOREIGN KEY (pergunta_id) REFERENCES perguntas (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pergunta_prova ADD CONSTRAINT FK_DDEBC297272FAB5F FOREIGN KEY (prova_id) REFERENCES provas (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE perguntas DROP CONSTRAINT fk_ec7ed227272fab5f');
        $this->addSql('DROP INDEX idx_ec7ed227272fab5f');
        $this->addSql('ALTER TABLE perguntas DROP prova_id');
        $this->addSql('ALTER TABLE respostas DROP CONSTRAINT FK_F20FC3577A567FF1');
        $this->addSql('DROP INDEX IDX_F20FC3577A567FF1');
        $this->addSql('ALTER TABLE respostas RENAME COLUMN pergunta_id TO perguntum_id');
        $this->addSql('ALTER TABLE respostas ADD CONSTRAINT FK_F20FC3577A567FF1 FOREIGN KEY (perguntum_id) REFERENCES perguntas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F20FC3577A567FF1 ON respostas (perguntum_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE pergunta_prova');
        $this->addSql('ALTER TABLE perguntas ADD prova_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN perguntas.prova_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE perguntas ADD CONSTRAINT fk_ec7ed227272fab5f FOREIGN KEY (prova_id) REFERENCES provas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_ec7ed227272fab5f ON perguntas (prova_id)');
        $this->addSql('ALTER TABLE respostas DROP CONSTRAINT fk_f20fc3577a567ff1');
        $this->addSql('DROP INDEX idx_f20fc3577a567ff1');
        $this->addSql('ALTER TABLE respostas RENAME COLUMN perguntum_id TO pergunta_id');
        $this->addSql('ALTER TABLE respostas ADD CONSTRAINT fk_f20fc3577a567ff1 FOREIGN KEY (pergunta_id) REFERENCES perguntas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f20fc3577a567ff1 ON respostas (pergunta_id)');
    }
}
