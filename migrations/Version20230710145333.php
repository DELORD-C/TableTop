<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230710145333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fighting_unit DROP FOREIGN KEY FK_446978E151796E0B');
        $this->addSql('ALTER TABLE fighting_unit DROP FOREIGN KEY FK_446978E199E6F5DF');
        $this->addSql('ALTER TABLE fighting_unit DROP FOREIGN KEY FK_446978E1E48FD905');
        $this->addSql('DROP TABLE fighting_unit');
        $this->addSql('ALTER TABLE player ADD is_fighting TINYINT(1) NOT NULL, ADD is_playing TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fighting_unit (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, pnj_id INT DEFAULT NULL, player_id INT DEFAULT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, is_playing TINYINT(1) NOT NULL, INDEX IDX_446978E1E48FD905 (game_id), UNIQUE INDEX UNIQ_446978E151796E0B (pnj_id), UNIQUE INDEX UNIQ_446978E199E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE fighting_unit ADD CONSTRAINT FK_446978E151796E0B FOREIGN KEY (pnj_id) REFERENCES pnj (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE fighting_unit ADD CONSTRAINT FK_446978E199E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE fighting_unit ADD CONSTRAINT FK_446978E1E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE player DROP is_fighting, DROP is_playing');
    }
}
