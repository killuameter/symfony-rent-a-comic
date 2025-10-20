<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221025153722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Author (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, birthDate DATETIME DEFAULT NULL, deathDate DATETIME DEFAULT NULL, nickname VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Book (id INT AUTO_INCREMENT NOT NULL, serie_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, reference VARCHAR(255) DEFAULT NULL, cover VARCHAR(255) NOT NULL, nbPage INT DEFAULT NULL, editor VARCHAR(255) NOT NULL, stock INT NOT NULL, slug VARCHAR(255) NOT NULL, dateCreated DATETIME NOT NULL, dateModified DATETIME NOT NULL, datePublished DATETIME DEFAULT NULL, seriePosition INT DEFAULT NULL, INDEX IDX_6BD70C0FD94388BD (serie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Cart (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, pickup_id INT DEFAULT NULL, dateModified DATETIME NOT NULL, dateCreated DATETIME NOT NULL, status VARCHAR(255) NOT NULL, totalAmont DOUBLE PRECISION DEFAULT NULL, dateToBeReturn DATETIME DEFAULT NULL, dateReallyReturned DATETIME DEFAULT NULL, INDEX IDX_AB912789A76ED395 (user_id), INDEX IDX_AB912789C26E160B (pickup_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_book (cart_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_2400A3081AD5CDBF (cart_id), INDEX IDX_2400A30816A2B381 (book_id), PRIMARY KEY(cart_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Category (id INT AUTO_INCREMENT NOT NULL, categoryName VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_serie (category_id INT NOT NULL, serie_id INT NOT NULL, INDEX IDX_4209DC7D12469DE2 (category_id), INDEX IDX_4209DC7DD94388BD (serie_id), PRIMARY KEY(category_id, serie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Fine (id INT AUTO_INCREMENT NOT NULL, cart_id INT DEFAULT NULL, dateCreated DATETIME NOT NULL, dateModified DATETIME NOT NULL, dateLimit DATETIME NOT NULL, amount DOUBLE PRECISION NOT NULL, motif VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_1E9BFBAC1AD5CDBF (cart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE PickupSpot (id INT AUTO_INCREMENT NOT NULL, latitude NUMERIC(9, 7) DEFAULT NULL, longitude NUMERIC(9, 7) DEFAULT NULL, storeName VARCHAR(255) NOT NULL, postalCode INT NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE RelBookAuthor (id INT AUTO_INCREMENT NOT NULL, books_id INT DEFAULT NULL, authors_id INT DEFAULT NULL, authorType VARCHAR(4) NOT NULL, INDEX IDX_1EB394E27DD8AC20 (books_id), INDEX IDX_1EB394E26DE2013A (authors_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Serie (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, language VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Transaction (id INT AUTO_INCREMENT NOT NULL, fine_id INT DEFAULT NULL, dateCreated DATETIME NOT NULL, dateValidationBq DATETIME NOT NULL, status VARCHAR(255) NOT NULL, amount NUMERIC(9, 2) DEFAULT NULL, transactionId VARCHAR(255) NOT NULL, message VARCHAR(255) NOT NULL, INDEX IDX_F4AB8A06E90B2A0C (fine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE User (id INT AUTO_INCREMENT NOT NULL, myMoney NUMERIC(9, 2) DEFAULT NULL, latitude NUMERIC(9, 7) DEFAULT NULL, longitude NUMERIC(9, 7) DEFAULT NULL, cb VARCHAR(255) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, nickname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, postal_code VARCHAR(15) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, subscriber TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Book ADD CONSTRAINT FK_6BD70C0FD94388BD FOREIGN KEY (serie_id) REFERENCES Serie (id)');
        $this->addSql('ALTER TABLE Cart ADD CONSTRAINT FK_AB912789A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE Cart ADD CONSTRAINT FK_AB912789C26E160B FOREIGN KEY (pickup_id) REFERENCES PickupSpot (id)');
        $this->addSql('ALTER TABLE cart_book ADD CONSTRAINT FK_2400A3081AD5CDBF FOREIGN KEY (cart_id) REFERENCES Cart (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_book ADD CONSTRAINT FK_2400A30816A2B381 FOREIGN KEY (book_id) REFERENCES Book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_serie ADD CONSTRAINT FK_4209DC7D12469DE2 FOREIGN KEY (category_id) REFERENCES Category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_serie ADD CONSTRAINT FK_4209DC7DD94388BD FOREIGN KEY (serie_id) REFERENCES Serie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Fine ADD CONSTRAINT FK_1E9BFBAC1AD5CDBF FOREIGN KEY (cart_id) REFERENCES Cart (id)');
        $this->addSql('ALTER TABLE RelBookAuthor ADD CONSTRAINT FK_1EB394E27DD8AC20 FOREIGN KEY (books_id) REFERENCES Book (id)');
        $this->addSql('ALTER TABLE RelBookAuthor ADD CONSTRAINT FK_1EB394E26DE2013A FOREIGN KEY (authors_id) REFERENCES Author (id)');
        $this->addSql('ALTER TABLE Transaction ADD CONSTRAINT FK_F4AB8A06E90B2A0C FOREIGN KEY (fine_id) REFERENCES Fine (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE RelBookAuthor DROP FOREIGN KEY FK_1EB394E26DE2013A');
        $this->addSql('ALTER TABLE cart_book DROP FOREIGN KEY FK_2400A30816A2B381');
        $this->addSql('ALTER TABLE RelBookAuthor DROP FOREIGN KEY FK_1EB394E27DD8AC20');
        $this->addSql('ALTER TABLE cart_book DROP FOREIGN KEY FK_2400A3081AD5CDBF');
        $this->addSql('ALTER TABLE Fine DROP FOREIGN KEY FK_1E9BFBAC1AD5CDBF');
        $this->addSql('ALTER TABLE category_serie DROP FOREIGN KEY FK_4209DC7D12469DE2');
        $this->addSql('ALTER TABLE Transaction DROP FOREIGN KEY FK_F4AB8A06E90B2A0C');
        $this->addSql('ALTER TABLE Cart DROP FOREIGN KEY FK_AB912789C26E160B');
        $this->addSql('ALTER TABLE Book DROP FOREIGN KEY FK_6BD70C0FD94388BD');
        $this->addSql('ALTER TABLE category_serie DROP FOREIGN KEY FK_4209DC7DD94388BD');
        $this->addSql('ALTER TABLE Cart DROP FOREIGN KEY FK_AB912789A76ED395');
        $this->addSql('DROP TABLE Author');
        $this->addSql('DROP TABLE Book');
        $this->addSql('DROP TABLE Cart');
        $this->addSql('DROP TABLE cart_book');
        $this->addSql('DROP TABLE Category');
        $this->addSql('DROP TABLE category_serie');
        $this->addSql('DROP TABLE Fine');
        $this->addSql('DROP TABLE PickupSpot');
        $this->addSql('DROP TABLE RelBookAuthor');
        $this->addSql('DROP TABLE Serie');
        $this->addSql('DROP TABLE Transaction');
        $this->addSql('DROP TABLE User');
    }
}
