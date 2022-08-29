<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220820134133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD is_dark_background TINYINT(1) NOT NULL, DROP background_color');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C15E237E06 ON category (name)');
        $this->addSql('ALTER TABLE cgu CHANGE content content LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE feedback CHANGE name name VARCHAR(255) NOT NULL, CHANGE content content LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D22944585E237E06 ON feedback (name)');
        $this->addSql('ALTER TABLE photos ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, DROP create_at, DROP update_at, CHANGE title name VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_876E0D95E237E06 ON photos (name)');
        $this->addSql('ALTER TABLE web_pages DROP FOREIGN KEY FK_ED67E1EB727ACA70');
        $this->addSql('DROP INDEX IDX_ED67E1EB727ACA70 ON web_pages');
        $this->addSql('ALTER TABLE web_pages ADD children VARCHAR(255) DEFAULT NULL, ADD parent VARCHAR(255) DEFAULT NULL, DROP parent_id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ED67E1EB5E237E06 ON web_pages (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_64C19C15E237E06 ON category');
        $this->addSql('ALTER TABLE category ADD background_color VARCHAR(255) NOT NULL, DROP is_dark_background');
        $this->addSql('ALTER TABLE cgu CHANGE content content LONGTEXT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_D22944585E237E06 ON feedback');
        $this->addSql('ALTER TABLE feedback CHANGE content content LONGTEXT NOT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_876E0D95E237E06 ON photos');
        $this->addSql('ALTER TABLE photos ADD create_at DATETIME NOT NULL, ADD update_at DATETIME NOT NULL, DROP created_at, DROP updated_at, CHANGE name title VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_ED67E1EB5E237E06 ON web_pages');
        $this->addSql('ALTER TABLE web_pages ADD parent_id INT DEFAULT NULL, DROP children, DROP parent');
        $this->addSql('ALTER TABLE web_pages ADD CONSTRAINT FK_ED67E1EB727ACA70 FOREIGN KEY (parent_id) REFERENCES web_pages (id)');
        $this->addSql('CREATE INDEX IDX_ED67E1EB727ACA70 ON web_pages (parent_id)');
    }
}
