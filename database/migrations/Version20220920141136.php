<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920141136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE perguntas DROP CONSTRAINT fk_ec7ed227ced4fa48');
        $this->addSql('DROP INDEX idx_ec7ed227ced4fa48');
        $this->addSql('ALTER TABLE perguntas RENAME COLUMN materium_id TO materia_id');
        $this->addSql('ALTER TABLE perguntas ADD CONSTRAINT FK_EC7ED227B54DBBCB FOREIGN KEY (materia_id) REFERENCES materias (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_EC7ED227B54DBBCB ON perguntas (materia_id)');
        $this->addSql('ALTER TABLE provas DROP CONSTRAINT fk_bf21961aced4fa48');
        $this->addSql('DROP INDEX idx_bf21961aced4fa48');
        $this->addSql('ALTER TABLE provas RENAME COLUMN materium_id TO materia_id');
        $this->addSql('ALTER TABLE provas ADD CONSTRAINT FK_BF21961AB54DBBCB FOREIGN KEY (materia_id) REFERENCES materias (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_BF21961AB54DBBCB ON provas (materia_id)');
        $this->addSql('ALTER TABLE respostas DROP CONSTRAINT fk_f20fc3577a567ff1');
        $this->addSql('DROP INDEX idx_f20fc3577a567ff1');
        $this->addSql('ALTER TABLE respostas RENAME COLUMN perguntum_id TO pergunta_id');
        $this->addSql('ALTER TABLE respostas ADD CONSTRAINT FK_F20FC3573C763537 FOREIGN KEY (pergunta_id) REFERENCES perguntas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F20FC3573C763537 ON respostas (pergunta_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE provas DROP CONSTRAINT FK_BF21961AB54DBBCB');
        $this->addSql('DROP INDEX IDX_BF21961AB54DBBCB');
        $this->addSql('ALTER TABLE provas RENAME COLUMN materia_id TO materium_id');
        $this->addSql('ALTER TABLE provas ADD CONSTRAINT fk_bf21961aced4fa48 FOREIGN KEY (materium_id) REFERENCES materias (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_bf21961aced4fa48 ON provas (materium_id)');
        $this->addSql('ALTER TABLE perguntas DROP CONSTRAINT FK_EC7ED227B54DBBCB');
        $this->addSql('DROP INDEX IDX_EC7ED227B54DBBCB');
        $this->addSql('ALTER TABLE perguntas RENAME COLUMN materia_id TO materium_id');
        $this->addSql('ALTER TABLE perguntas ADD CONSTRAINT fk_ec7ed227ced4fa48 FOREIGN KEY (materium_id) REFERENCES materias (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_ec7ed227ced4fa48 ON perguntas (materium_id)');
        $this->addSql('ALTER TABLE respostas DROP CONSTRAINT FK_F20FC3573C763537');
        $this->addSql('DROP INDEX IDX_F20FC3573C763537');
        $this->addSql('ALTER TABLE respostas RENAME COLUMN pergunta_id TO perguntum_id');
        $this->addSql('ALTER TABLE respostas ADD CONSTRAINT fk_f20fc3577a567ff1 FOREIGN KEY (perguntum_id) REFERENCES perguntas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f20fc3577a567ff1 ON respostas (perguntum_id)');
    }
}
