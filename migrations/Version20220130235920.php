<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220130235920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipo (id INT AUTO_INCREMENT NOT NULL, marca_id INT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, modelo VARCHAR(30) NOT NULL, numero_serie VARCHAR(20) DEFAULT NULL, nombre_equipo VARCHAR(50) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_C49C530BD17F50A6 (uuid), INDEX IDX_C49C530B81EF0041 (marca_id), INDEX IDX_C49C530B53C8D32C (propietario_id), INDEX IDX_C49C530B24DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipo ADD CONSTRAINT FK_C49C530B81EF0041 FOREIGN KEY (marca_id) REFERENCES equipo_marca (id)');
        $this->addSql('ALTER TABLE equipo ADD CONSTRAINT FK_C49C530B53C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE equipo ADD CONSTRAINT FK_C49C530B24DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE equipo');
    }
}
