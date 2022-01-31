<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220131065943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detalle_orden (id INT AUTO_INCREMENT NOT NULL, tipo_servicio_detalle_orden_id INT NOT NULL, orden_servicio_id INT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, observacion VARCHAR(255) DEFAULT NULL, precio NUMERIC(10, 2) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_3F5E8583D17F50A6 (uuid), INDEX IDX_3F5E85834E389608 (tipo_servicio_detalle_orden_id), INDEX IDX_3F5E858344C5C340 (orden_servicio_id), INDEX IDX_3F5E858353C8D32C (propietario_id), INDEX IDX_3F5E858324DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detalle_orden ADD CONSTRAINT FK_3F5E85834E389608 FOREIGN KEY (tipo_servicio_detalle_orden_id) REFERENCES tipo_servicio (id)');
        $this->addSql('ALTER TABLE detalle_orden ADD CONSTRAINT FK_3F5E858344C5C340 FOREIGN KEY (orden_servicio_id) REFERENCES orden_servicio (id)');
        $this->addSql('ALTER TABLE detalle_orden ADD CONSTRAINT FK_3F5E858353C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE detalle_orden ADD CONSTRAINT FK_3F5E858324DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE detalle_orden');
    }
}
