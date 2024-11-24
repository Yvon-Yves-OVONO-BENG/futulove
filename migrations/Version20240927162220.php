<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240927162220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE photo_message_groupe (id INT AUTO_INCREMENT NOT NULL, message_groupe_id INT DEFAULT NULL, photo_message_groupe VARCHAR(255) NOT NULL, INDEX IDX_2BAD677310FC33BA (message_groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photo_message_groupe ADD CONSTRAINT FK_2BAD677310FC33BA FOREIGN KEY (message_groupe_id) REFERENCES message_groupe (id)');
        $this->addSql('ALTER TABLE user CHANGE nom nom VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photo_message_groupe DROP FOREIGN KEY FK_2BAD677310FC33BA');
        $this->addSql('DROP TABLE photo_message_groupe');
        $this->addSql('ALTER TABLE user CHANGE nom nom VARCHAR(255) DEFAULT NULL');
    }
}
