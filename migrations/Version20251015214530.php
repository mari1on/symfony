<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251015214530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auth (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bo (id INT AUTO_INCREMENT NOT NULL, auth_id INT DEFAULT NULL, id_bk INT NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_CB1F67138082819C (auth_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bo ADD CONSTRAINT FK_CB1F67138082819C FOREIGN KEY (auth_id) REFERENCES auth (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bo DROP FOREIGN KEY FK_CB1F67138082819C');
        $this->addSql('DROP TABLE auth');
        $this->addSql('DROP TABLE bo');
    }
}
