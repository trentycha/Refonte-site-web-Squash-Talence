<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251008165940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE histo_resa (Id_histo_resa INT AUTO_INCREMENT NOT NULL, date_ DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', hour_ TIME NOT NULL, time_ TIME NOT NULL, court INT NOT NULL, status TINYINT(1) NOT NULL, Id_user INT DEFAULT NULL, INDEX IDX_19EE86F4C90EF3D7 (Id_user), PRIMARY KEY(Id_histo_resa)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (parent_post INT DEFAULT NULL, Id_post INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', Id_user INT NOT NULL, INDEX IDX_5A8A6C8DC90EF3D7 (Id_user), INDEX IDX_5A8A6C8D67695A39 (parent_post), PRIMARY KEY(Id_post)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, user_name VARCHAR(100) NOT NULL, date DATE NOT NULL, duree INT NOT NULL, terrain INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_ (Id_user INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, phone VARCHAR(50) NOT NULL, password VARCHAR(100) NOT NULL, isSubscribed TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_EMAIL (email), PRIMARY KEY(Id_user)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE histo_resa ADD CONSTRAINT FK_19EE86F4C90EF3D7 FOREIGN KEY (Id_user) REFERENCES user_ (Id_user)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DC90EF3D7 FOREIGN KEY (Id_user) REFERENCES user_ (Id_user)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D67695A39 FOREIGN KEY (parent_post) REFERENCES post (Id_post)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE histo_resa DROP FOREIGN KEY FK_19EE86F4C90EF3D7');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DC90EF3D7');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D67695A39');
        $this->addSql('DROP TABLE histo_resa');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE user_');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
