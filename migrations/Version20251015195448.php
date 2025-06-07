<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251015195448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE histo_resa DROP time_, DROP court, DROP status, CHANGE Id_user id_user INT NOT NULL');
        $this->addSql('ALTER TABLE histo_resa RENAME INDEX idx_19ee86f4c90ef3d7 TO IDX_19EE86F46B3CA4B');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE histo_resa ADD time_ TIME NOT NULL, ADD court INT NOT NULL, ADD status TINYINT(1) NOT NULL, CHANGE id_user Id_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE histo_resa RENAME INDEX idx_19ee86f46b3ca4b TO IDX_19EE86F4C90EF3D7');
    }
}
