<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220131042118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE orden_servicio (id INT AUTO_INCREMENT NOT NULL, cliente_orden_id INT NOT NULL, tecnico_orden_id INT NOT NULL, equipo_id INT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, numero_orden VARCHAR(6) NOT NULL, relation VARCHAR(5) NOT NULL, fecha_ingreso DATETIME NOT NULL, fecha_salida DATETIME DEFAULT NULL, precio NUMERIC(10, 2) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_17EC71FDD17F50A6 (uuid), INDEX IDX_17EC71FD2D610281 (cliente_orden_id), INDEX IDX_17EC71FD91441E33 (tecnico_orden_id), INDEX IDX_17EC71FD23BFBED (equipo_id), INDEX IDX_17EC71FD53C8D32C (propietario_id), INDEX IDX_17EC71FD24DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orden_servicio_estado (orden_servicio_id INT NOT NULL, estado_id INT NOT NULL, INDEX IDX_3A53C6E544C5C340 (orden_servicio_id), INDEX IDX_3A53C6E59F5A440B (estado_id), PRIMARY KEY(orden_servicio_id, estado_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orden_servicio ADD CONSTRAINT FK_17EC71FD2D610281 FOREIGN KEY (cliente_orden_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE orden_servicio ADD CONSTRAINT FK_17EC71FD91441E33 FOREIGN KEY (tecnico_orden_id) REFERENCES tecnico_encargado (id)');
        $this->addSql('ALTER TABLE orden_servicio ADD CONSTRAINT FK_17EC71FD23BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id)');
        $this->addSql('ALTER TABLE orden_servicio ADD CONSTRAINT FK_17EC71FD53C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE orden_servicio ADD CONSTRAINT FK_17EC71FD24DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE orden_servicio_estado ADD CONSTRAINT FK_3A53C6E544C5C340 FOREIGN KEY (orden_servicio_id) REFERENCES orden_servicio (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orden_servicio_estado ADD CONSTRAINT FK_3A53C6E59F5A440B FOREIGN KEY (estado_id) REFERENCES estado (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orden_servicio_estado DROP FOREIGN KEY FK_3A53C6E544C5C340');
        $this->addSql('DROP TABLE orden_servicio');
        $this->addSql('DROP TABLE orden_servicio_estado');
    }
}
