<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250114092501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, inventory_id INT NOT NULL, INDEX IDX_64C19C19EEA759 (inventory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, notes LONGTEXT DEFAULT NULL, map VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, ambiance VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE inventory (id INT AUTO_INCREMENT NOT NULL, money INT NOT NULL, game_id INT NOT NULL, UNIQUE INDEX UNIQ_B12D4A36E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, count INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, category_id INT NOT NULL, INDEX IDX_1F1B251E12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE music (id INT AUTO_INCREMENT NOT NULL, file VARCHAR(255) NOT NULL, list INT NOT NULL, played INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE pin (id INT AUTO_INCREMENT NOT NULL, x DOUBLE PRECISION NOT NULL, y DOUBLE PRECISION NOT NULL, name VARCHAR(255) DEFAULT NULL, note VARCHAR(1000) DEFAULT NULL, team TINYINT(1) NOT NULL, color VARCHAR(255) DEFAULT NULL, game_id INT NOT NULL, INDEX IDX_B5852DF3E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, race VARCHAR(255) DEFAULT NULL, class VARCHAR(255) DEFAULT NULL, pvm INT DEFAULT NULL, pv INT DEFAULT NULL, pcm INT DEFAULT NULL, pc INT DEFAULT NULL, pmm INT DEFAULT NULL, pm INT DEFAULT NULL, pd INT DEFAULT NULL, lvl INT DEFAULT NULL, lore LONGTEXT DEFAULT NULL, activ LONGTEXT DEFAULT NULL, passiv LONGTEXT DEFAULT NULL, dmg_dice VARCHAR(255) DEFAULT NULL, dmg_fixed INT DEFAULT NULL, intel INT DEFAULT NULL, strength INT DEFAULT NULL, social INT DEFAULT NULL, perception INT DEFAULT NULL, speed INT DEFAULT NULL, is_fighting TINYINT(1) NOT NULL, is_playing TINYINT(1) NOT NULL, spec VARCHAR(255) DEFAULT NULL, job VARCHAR(255) DEFAULT NULL, temp LONGTEXT DEFAULT NULL, game_id INT NOT NULL, token_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_98197A65F85E0677 (username), INDEX IDX_98197A65E48FD905 (game_id), INDEX IDX_98197A6541DEE7B9 (token_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE pnj (id INT AUTO_INCREMENT NOT NULL, pvm INT DEFAULT NULL, pv INT DEFAULT NULL, note LONGTEXT DEFAULT NULL, speed INT DEFAULT NULL, name VARCHAR(255) NOT NULL, dmg_dice VARCHAR(255) DEFAULT NULL, dmg_fixed INT DEFAULT NULL, is_fighting TINYINT(1) NOT NULL, is_playing TINYINT(1) NOT NULL, hit INT DEFAULT NULL, game_id INT NOT NULL, token_id INT DEFAULT NULL, INDEX IDX_FDA97F2DE48FD905 (game_id), INDEX IDX_FDA97F2D41DEE7B9 (token_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE sound (id INT AUTO_INCREMENT NOT NULL, file VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, game_id INT NOT NULL, INDEX IDX_F88EC384E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE token (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C19EEA759 FOREIGN KEY (inventory_id) REFERENCES inventory (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pin ADD CONSTRAINT FK_B5852DF3E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A6541DEE7B9 FOREIGN KEY (token_id) REFERENCES token (id)');
        $this->addSql('ALTER TABLE pnj ADD CONSTRAINT FK_FDA97F2DE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pnj ADD CONSTRAINT FK_FDA97F2D41DEE7B9 FOREIGN KEY (token_id) REFERENCES token (id)');
        $this->addSql('ALTER TABLE sound ADD CONSTRAINT FK_F88EC384E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C19EEA759');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36E48FD905');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E12469DE2');
        $this->addSql('ALTER TABLE pin DROP FOREIGN KEY FK_B5852DF3E48FD905');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65E48FD905');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A6541DEE7B9');
        $this->addSql('ALTER TABLE pnj DROP FOREIGN KEY FK_FDA97F2DE48FD905');
        $this->addSql('ALTER TABLE pnj DROP FOREIGN KEY FK_FDA97F2D41DEE7B9');
        $this->addSql('ALTER TABLE sound DROP FOREIGN KEY FK_F88EC384E48FD905');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE music');
        $this->addSql('DROP TABLE pin');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE pnj');
        $this->addSql('DROP TABLE sound');
        $this->addSql('DROP TABLE token');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
