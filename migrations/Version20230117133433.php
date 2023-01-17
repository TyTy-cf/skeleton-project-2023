<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230117133433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postal_code DROP FOREIGN KEY FK_EA98E376CAC75398');
        $this->addSql('DROP INDEX IDX_EA98E376CAC75398 ON postal_code');
        $this->addSql('ALTER TABLE postal_code CHANGE cities_id city_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE postal_code ADD CONSTRAINT FK_EA98E3768BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_EA98E3768BAC62AF ON postal_code (city_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postal_code DROP FOREIGN KEY FK_EA98E3768BAC62AF');
        $this->addSql('DROP INDEX IDX_EA98E3768BAC62AF ON postal_code');
        $this->addSql('ALTER TABLE postal_code CHANGE city_id cities_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE postal_code ADD CONSTRAINT FK_EA98E376CAC75398 FOREIGN KEY (cities_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_EA98E376CAC75398 ON postal_code (cities_id)');
    }
}
