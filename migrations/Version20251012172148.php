<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251012172148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, authorr_id INT NOT NULL, title VARCHAR(255) NOT NULL, publication_date DATE NOT NULL, category VARCHAR(255) NOT NULL, INDEX IDX_CBE5A331D55E665F (authorr_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331D55E665F FOREIGN KEY (authorr_id) REFERENCES authorr (id)');
        $this->addSql('ALTER TABLE authorr DROP no');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331D55E665F');
        $this->addSql('DROP TABLE book');
        $this->addSql('ALTER TABLE authorr ADD no VARCHAR(255) NOT NULL');
    }
}
