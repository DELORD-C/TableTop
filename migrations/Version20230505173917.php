<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230505173917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pnj ADD token_id INT DEFAULT NULL, CHANGE pvm pvm INT DEFAULT NULL, CHANGE pv pv INT DEFAULT NULL, CHANGE speed speed INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pnj ADD CONSTRAINT FK_FDA97F2D41DEE7B9 FOREIGN KEY (token_id) REFERENCES token (id)');
        $this->addSql('CREATE INDEX IDX_FDA97F2D41DEE7B9 ON pnj (token_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pnj DROP FOREIGN KEY FK_FDA97F2D41DEE7B9');
        $this->addSql('DROP INDEX IDX_FDA97F2D41DEE7B9 ON pnj');
        $this->addSql('ALTER TABLE pnj DROP token_id, CHANGE pvm pvm INT NOT NULL, CHANGE pv pv INT NOT NULL, CHANGE speed speed INT NOT NULL');
    }
}
