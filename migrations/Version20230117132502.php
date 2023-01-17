<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230117132502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city CHANGE code code VARCHAR(8) NOT NULL');
        $this->addSql('ALTER TABLE department CHANGE code code VARCHAR(8) NOT NULL');
        $this->addSql('ALTER TABLE region CHANGE code code VARCHAR(8) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city CHANGE code code VARCHAR(4) NOT NULL');
        $this->addSql('ALTER TABLE department CHANGE code code VARCHAR(4) NOT NULL');
        $this->addSql('ALTER TABLE region CHANGE code code VARCHAR(4) NOT NULL');
    }
}
