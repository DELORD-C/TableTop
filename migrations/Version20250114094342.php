<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250114094342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE music (id INT AUTO_INCREMENT NOT NULL, file VARCHAR(255) NOT NULL, list INT NOT NULL, played INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE sound (id INT AUTO_INCREMENT NOT NULL, file VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, game_id INT NOT NULL, INDEX IDX_F88EC384E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE sound ADD CONSTRAINT FK_F88EC384E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game ADD ambiance VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE player ADD spec VARCHAR(255) DEFAULT NULL, ADD job VARCHAR(255) DEFAULT NULL, ADD temp LONGTEXT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sound DROP FOREIGN KEY FK_F88EC384E48FD905');
        $this->addSql('DROP TABLE music');
        $this->addSql('DROP TABLE sound');
        $this->addSql('ALTER TABLE game DROP ambiance');
        $this->addSql('ALTER TABLE player DROP spec, DROP job, DROP temp, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
