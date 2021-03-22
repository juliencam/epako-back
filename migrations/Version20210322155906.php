<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210322155906 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6DA6A219');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6DA6A219 FOREIGN KEY (place_id) REFERENCES place (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6DA6A219');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
    }
}
