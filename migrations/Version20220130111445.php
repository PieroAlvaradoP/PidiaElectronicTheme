<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220130111445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tecnico_encargado ADD propietario_id INT DEFAULT NULL, ADD config_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, ADD activo TINYINT(1) NOT NULL, ADD uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE tecnico_encargado ADD CONSTRAINT FK_CEDE9F5B53C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE tecnico_encargado ADD CONSTRAINT FK_CEDE9F5B24DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CEDE9F5BD17F50A6 ON tecnico_encargado (uuid)');
        $this->addSql('CREATE INDEX IDX_CEDE9F5B53C8D32C ON tecnico_encargado (propietario_id)');
        $this->addSql('CREATE INDEX IDX_CEDE9F5B24DB0683 ON tecnico_encargado (config_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tecnico_encargado DROP FOREIGN KEY FK_CEDE9F5B53C8D32C');
        $this->addSql('ALTER TABLE tecnico_encargado DROP FOREIGN KEY FK_CEDE9F5B24DB0683');
        $this->addSql('DROP INDEX UNIQ_CEDE9F5BD17F50A6 ON tecnico_encargado');
        $this->addSql('DROP INDEX IDX_CEDE9F5B53C8D32C ON tecnico_encargado');
        $this->addSql('DROP INDEX IDX_CEDE9F5B24DB0683 ON tecnico_encargado');
        $this->addSql('ALTER TABLE tecnico_encargado DROP propietario_id, DROP config_id, DROP created_at, DROP updated_at, DROP activo, DROP uuid');
    }
}
