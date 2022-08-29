<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220820155906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE web_pages ADD parent_id INT DEFAULT NULL, DROP children, DROP parent');
        $this->addSql('ALTER TABLE web_pages ADD CONSTRAINT FK_ED67E1EB727ACA70 FOREIGN KEY (parent_id) REFERENCES web_pages (id)');
        $this->addSql('CREATE INDEX IDX_ED67E1EB727ACA70 ON web_pages (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE web_pages DROP FOREIGN KEY FK_ED67E1EB727ACA70');
        $this->addSql('DROP INDEX IDX_ED67E1EB727ACA70 ON web_pages');
        $this->addSql('ALTER TABLE web_pages ADD children VARCHAR(255) DEFAULT NULL, ADD parent VARCHAR(255) DEFAULT NULL, DROP parent_id');
    }
}
