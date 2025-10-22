<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251016125120 extends AbstractMigration
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
        $this->addSql('CREATE TABLE reader (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reader_book (reader_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_2A3845F31717D737 (reader_id), INDEX IDX_2A3845F316A2B381 (book_id), PRIMARY KEY(reader_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bo ADD CONSTRAINT FK_CB1F67138082819C FOREIGN KEY (auth_id) REFERENCES auth (id)');
        $this->addSql('ALTER TABLE reader_book ADD CONSTRAINT FK_2A3845F31717D737 FOREIGN KEY (reader_id) REFERENCES reader (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reader_book ADD CONSTRAINT FK_2A3845F316A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE authorr DROP nb_book');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bo DROP FOREIGN KEY FK_CB1F67138082819C');
        $this->addSql('ALTER TABLE reader_book DROP FOREIGN KEY FK_2A3845F31717D737');
        $this->addSql('ALTER TABLE reader_book DROP FOREIGN KEY FK_2A3845F316A2B381');
        $this->addSql('DROP TABLE auth');
        $this->addSql('DROP TABLE bo');
        $this->addSql('DROP TABLE reader');
        $this->addSql('DROP TABLE reader_book');
        $this->addSql('ALTER TABLE authorr ADD nb_book INT DEFAULT NULL');
    }
}
