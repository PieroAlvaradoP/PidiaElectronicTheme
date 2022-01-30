<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220130004931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE config (id INT AUTO_INCREMENT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, alias VARCHAR(15) NOT NULL, nombre VARCHAR(255) NOT NULL, nombre_corto VARCHAR(30) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_D48A2F7CD17F50A6 (uuid), INDEX IDX_D48A2F7C53C8D32C (propietario_id), INDEX IDX_D48A2F7C24DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE config_config_menu_menus (config_id INT NOT NULL, config_menu_id INT NOT NULL, INDEX IDX_A8E9CD3124DB0683 (config_id), INDEX IDX_A8E9CD31B9CB2BE2 (config_menu_id), PRIMARY KEY(config_id, config_menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE config_menu (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, route VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, padre_id INT DEFAULT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, nombre VARCHAR(50) NOT NULL, ruta VARCHAR(50) DEFAULT NULL, icono VARCHAR(50) DEFAULT NULL, orden SMALLINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_7D053A93D17F50A6 (uuid), INDEX IDX_7D053A93613CEC58 (padre_id), INDEX IDX_7D053A9353C8D32C (propietario_id), INDEX IDX_7D053A9324DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parametro (id INT AUTO_INCREMENT NOT NULL, padre_id INT DEFAULT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, nombre VARCHAR(100) NOT NULL, alias VARCHAR(16) DEFAULT NULL, valor NUMERIC(10, 2) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_4C12795FD17F50A6 (uuid), INDEX IDX_4C12795F613CEC58 (padre_id), INDEX IDX_4C12795F53C8D32C (propietario_id), INDEX IDX_4C12795F24DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, username VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(100) NOT NULL, full_name VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_2265B05DE7927C74 (email), UNIQUE INDEX UNIQ_2265B05DD17F50A6 (uuid), INDEX IDX_2265B05D53C8D32C (propietario_id), INDEX IDX_2265B05D24DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario_usuario_rol (usuario_id INT NOT NULL, usuario_rol_id INT NOT NULL, INDEX IDX_4AC6232ADB38439E (usuario_id), INDEX IDX_4AC6232AFEA85A65 (usuario_rol_id), PRIMARY KEY(usuario_id, usuario_rol_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario_permiso (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, listar TINYINT(1) DEFAULT NULL, mostrar TINYINT(1) DEFAULT NULL, crear TINYINT(1) DEFAULT NULL, editar TINYINT(1) DEFAULT NULL, eliminar TINYINT(1) DEFAULT NULL, imprimir TINYINT(1) DEFAULT NULL, exportar TINYINT(1) DEFAULT NULL, importar TINYINT(1) DEFAULT NULL, maestro TINYINT(1) DEFAULT NULL, INDEX IDX_845C01D9CCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario_permiso_usuario_rol (usuario_permiso_id INT NOT NULL, usuario_rol_id INT NOT NULL, INDEX IDX_B45A84629FDFE795 (usuario_permiso_id), INDEX IDX_B45A8462FEA85A65 (usuario_rol_id), PRIMARY KEY(usuario_permiso_id, usuario_rol_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario_rol (id INT AUTO_INCREMENT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, nombre VARCHAR(50) NOT NULL, rol VARCHAR(30) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_72EDD1A4D17F50A6 (uuid), INDEX IDX_72EDD1A453C8D32C (propietario_id), INDEX IDX_72EDD1A424DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE config ADD CONSTRAINT FK_D48A2F7C53C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE config ADD CONSTRAINT FK_D48A2F7C24DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE config_config_menu_menus ADD CONSTRAINT FK_A8E9CD3124DB0683 FOREIGN KEY (config_id) REFERENCES config (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE config_config_menu_menus ADD CONSTRAINT FK_A8E9CD31B9CB2BE2 FOREIGN KEY (config_menu_id) REFERENCES config_menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93613CEC58 FOREIGN KEY (padre_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A9353C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A9324DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE parametro ADD CONSTRAINT FK_4C12795F613CEC58 FOREIGN KEY (padre_id) REFERENCES parametro (id)');
        $this->addSql('ALTER TABLE parametro ADD CONSTRAINT FK_4C12795F53C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE parametro ADD CONSTRAINT FK_4C12795F24DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05D53C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05D24DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE usuario_usuario_rol ADD CONSTRAINT FK_4AC6232ADB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE usuario_usuario_rol ADD CONSTRAINT FK_4AC6232AFEA85A65 FOREIGN KEY (usuario_rol_id) REFERENCES usuario_rol (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE usuario_permiso ADD CONSTRAINT FK_845C01D9CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE usuario_permiso_usuario_rol ADD CONSTRAINT FK_B45A84629FDFE795 FOREIGN KEY (usuario_permiso_id) REFERENCES usuario_permiso (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE usuario_permiso_usuario_rol ADD CONSTRAINT FK_B45A8462FEA85A65 FOREIGN KEY (usuario_rol_id) REFERENCES usuario_rol (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE usuario_rol ADD CONSTRAINT FK_72EDD1A453C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE usuario_rol ADD CONSTRAINT FK_72EDD1A424DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE config DROP FOREIGN KEY FK_D48A2F7C24DB0683');
        $this->addSql('ALTER TABLE config_config_menu_menus DROP FOREIGN KEY FK_A8E9CD3124DB0683');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A9324DB0683');
        $this->addSql('ALTER TABLE parametro DROP FOREIGN KEY FK_4C12795F24DB0683');
        $this->addSql('ALTER TABLE usuario DROP FOREIGN KEY FK_2265B05D24DB0683');
        $this->addSql('ALTER TABLE usuario_rol DROP FOREIGN KEY FK_72EDD1A424DB0683');
        $this->addSql('ALTER TABLE config_config_menu_menus DROP FOREIGN KEY FK_A8E9CD31B9CB2BE2');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93613CEC58');
        $this->addSql('ALTER TABLE usuario_permiso DROP FOREIGN KEY FK_845C01D9CCD7E912');
        $this->addSql('ALTER TABLE parametro DROP FOREIGN KEY FK_4C12795F613CEC58');
        $this->addSql('ALTER TABLE config DROP FOREIGN KEY FK_D48A2F7C53C8D32C');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A9353C8D32C');
        $this->addSql('ALTER TABLE parametro DROP FOREIGN KEY FK_4C12795F53C8D32C');
        $this->addSql('ALTER TABLE usuario DROP FOREIGN KEY FK_2265B05D53C8D32C');
        $this->addSql('ALTER TABLE usuario_usuario_rol DROP FOREIGN KEY FK_4AC6232ADB38439E');
        $this->addSql('ALTER TABLE usuario_rol DROP FOREIGN KEY FK_72EDD1A453C8D32C');
        $this->addSql('ALTER TABLE usuario_permiso_usuario_rol DROP FOREIGN KEY FK_B45A84629FDFE795');
        $this->addSql('ALTER TABLE usuario_usuario_rol DROP FOREIGN KEY FK_4AC6232AFEA85A65');
        $this->addSql('ALTER TABLE usuario_permiso_usuario_rol DROP FOREIGN KEY FK_B45A8462FEA85A65');
        $this->addSql('DROP TABLE config');
        $this->addSql('DROP TABLE config_config_menu_menus');
        $this->addSql('DROP TABLE config_menu');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE parametro');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE usuario_usuario_rol');
        $this->addSql('DROP TABLE usuario_permiso');
        $this->addSql('DROP TABLE usuario_permiso_usuario_rol');
        $this->addSql('DROP TABLE usuario_rol');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
