<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210318160204 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, postalcode SMALLINT UNSIGNED NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_CD1DE18A5E237E06 (name), UNIQUE INDEX UNIQ_CD1DE18A65DA68E7 (postalcode), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE place (id INT AUTO_INCREMENT NOT NULL, department_id INT NOT NULL, place_category_id INT NOT NULL, name VARCHAR(64) NOT NULL, address VARCHAR(255) NOT NULL, address_complement VARCHAR(64) DEFAULT NULL, city VARCHAR(64) NOT NULL, logo VARCHAR(64) DEFAULT NULL, status SMALLINT UNSIGNED DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, published_at DATETIME DEFAULT NULL, INDEX IDX_741D53CDAE80F5DF (department_id), INDEX IDX_741D53CD1CB3D546 (place_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE place_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, pictogram VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_2C17FE425E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, place_id INT DEFAULT NULL, content LONGTEXT NOT NULL, rate SMALLINT UNSIGNED DEFAULT 1 NOT NULL, status SMALLINT UNSIGNED DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, published_at DATETIME DEFAULT NULL, INDEX IDX_794381C6A76ED395 (user_id), INDEX IDX_794381C6DA6A219 (place_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nickname VARCHAR(64) NOT NULL, status SMALLINT UNSIGNED DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CDAE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CD1CB3D546 FOREIGN KEY (place_category_id) REFERENCES place_category (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CDAE80F5DF');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6DA6A219');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CD1CB3D546');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6A76ED395');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE place_category');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE user');
    }
}
