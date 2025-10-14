<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251013121120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE instructor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, specialization VARCHAR(255) NOT NULL, bio VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE workshop ADD instructor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE workshop ADD CONSTRAINT FK_9B6F02C48C4FC193 FOREIGN KEY (instructor_id) REFERENCES instructor (id)');
        $this->addSql('CREATE INDEX IDX_9B6F02C48C4FC193 ON workshop (instructor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workshop DROP FOREIGN KEY FK_9B6F02C48C4FC193');
        $this->addSql('DROP TABLE instructor');
        $this->addSql('DROP INDEX IDX_9B6F02C48C4FC193 ON workshop');
        $this->addSql('ALTER TABLE workshop DROP instructor_id');
    }
}
