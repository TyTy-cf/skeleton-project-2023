<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230117133045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city_postal_code DROP FOREIGN KEY FK_C92CFD798BAC62AF');
        $this->addSql('ALTER TABLE city_postal_code DROP FOREIGN KEY FK_C92CFD79BDBA6A61');
        $this->addSql('DROP TABLE city_postal_code');
        $this->addSql('ALTER TABLE postal_code ADD cities_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE postal_code ADD CONSTRAINT FK_EA98E376CAC75398 FOREIGN KEY (cities_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_EA98E376CAC75398 ON postal_code (cities_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city_postal_code (city_id INT NOT NULL, postal_code_id INT NOT NULL, INDEX IDX_C92CFD79BDBA6A61 (postal_code_id), INDEX IDX_C92CFD798BAC62AF (city_id), PRIMARY KEY(city_id, postal_code_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE city_postal_code ADD CONSTRAINT FK_C92CFD798BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE city_postal_code ADD CONSTRAINT FK_C92CFD79BDBA6A61 FOREIGN KEY (postal_code_id) REFERENCES postal_code (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE postal_code DROP FOREIGN KEY FK_EA98E376CAC75398');
        $this->addSql('DROP INDEX IDX_EA98E376CAC75398 ON postal_code');
        $this->addSql('ALTER TABLE postal_code DROP cities_id');
    }
}
