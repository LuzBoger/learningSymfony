<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241102142753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD nom VARCHAR(255) NOT NULL, DROP name, CHANGE label label VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF8697D13');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9395C3F3');
        $this->addSql('DROP INDEX IDX_9474526C9395C3F3 ON comment');
        $this->addSql('DROP INDEX IDX_9474526CF8697D13 ON comment');
        $this->addSql('ALTER TABLE comment ADD parent_comment_id INT DEFAULT NULL, ADD publisher_id INT NOT NULL, DROP customer_id, DROP comment_id, CHANGE media_id media_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CBF2AF943 FOREIGN KEY (parent_comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C40C86FCE FOREIGN KEY (publisher_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_9474526CBF2AF943 ON comment (parent_comment_id)');
        $this->addSql('CREATE INDEX IDX_9474526C40C86FCE ON comment (publisher_id)');
        $this->addSql('ALTER TABLE episode ADD season_id INT NOT NULL, CHANGE duration duration INT NOT NULL, CHANGE release_date released_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id)');
        $this->addSql('CREATE INDEX IDX_DDAA1CDA4EC001D1 ON episode (season_id)');
        $this->addSql('ALTER TABLE language ADD nom VARCHAR(255) NOT NULL, DROP name, CHANGE code code VARCHAR(3) NOT NULL');
        $this->addSql('ALTER TABLE media ADD discr VARCHAR(255) NOT NULL, DROP media_type, DROP type');
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112D9395C3F3');
        $this->addSql('DROP INDEX IDX_D782112D9395C3F3 ON playlist');
        $this->addSql('ALTER TABLE playlist ADD creator_id INT NOT NULL, DROP customer_id');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112D61220EA6 FOREIGN KEY (creator_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_D782112D61220EA6 ON playlist (creator_id)');
        $this->addSql('ALTER TABLE playlist_media CHANGE media_id media_id INT NOT NULL, CHANGE playlist_id playlist_id INT NOT NULL');
        $this->addSql('ALTER TABLE playlist_subscription DROP FOREIGN KEY FK_832940C9395C3F3');
        $this->addSql('DROP INDEX IDX_832940C9395C3F3 ON playlist_subscription');
        $this->addSql('ALTER TABLE playlist_subscription ADD subscriber_id INT NOT NULL, DROP customer_id, CHANGE playlist_id playlist_id INT NOT NULL');
        $this->addSql('ALTER TABLE playlist_subscription ADD CONSTRAINT FK_832940C7808B1AD FOREIGN KEY (subscriber_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_832940C7808B1AD ON playlist_subscription (subscriber_id)');
        $this->addSql('ALTER TABLE season ADD number VARCHAR(255) NOT NULL, CHANGE season_number serie_id INT NOT NULL');
        $this->addSql('ALTER TABLE season ADD CONSTRAINT FK_F0E45BA9D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
        $this->addSql('CREATE INDEX IDX_F0E45BA9D94388BD ON season (serie_id)');
        $this->addSql('ALTER TABLE subscription_history ADD subscriber_id INT NOT NULL, ADD end_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP start_date, CHANGE subscription_id subscription_id INT NOT NULL, CHANGE end_date start_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE subscription_history ADD CONSTRAINT FK_54AF90D07808B1AD FOREIGN KEY (subscriber_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_54AF90D07808B1AD ON subscription_history (subscriber_id)');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE watch_history DROP FOREIGN KEY FK_DE44EFD89395C3F3');
        $this->addSql('DROP INDEX IDX_DE44EFD89395C3F3 ON watch_history');
        $this->addSql('ALTER TABLE watch_history ADD watcher_id INT NOT NULL, DROP customer_id, CHANGE media_id media_id INT NOT NULL, CHANGE last_watched last_watched_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE watch_history ADD CONSTRAINT FK_DE44EFD8C300AB5D FOREIGN KEY (watcher_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_DE44EFD8C300AB5D ON watch_history (watcher_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD name VARCHAR(100) NOT NULL, DROP nom, CHANGE label label VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CBF2AF943');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C40C86FCE');
        $this->addSql('DROP INDEX IDX_9474526CBF2AF943 ON comment');
        $this->addSql('DROP INDEX IDX_9474526C40C86FCE ON comment');
        $this->addSql('ALTER TABLE comment ADD comment_id INT DEFAULT NULL, DROP publisher_id, CHANGE media_id media_id INT DEFAULT NULL, CHANGE parent_comment_id customer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9474526C9395C3F3 ON comment (customer_id)');
        $this->addSql('CREATE INDEX IDX_9474526CF8697D13 ON comment (comment_id)');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDA4EC001D1');
        $this->addSql('DROP INDEX IDX_DDAA1CDA4EC001D1 ON episode');
        $this->addSql('ALTER TABLE episode DROP season_id, CHANGE duration duration TIME NOT NULL, CHANGE released_at release_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE language ADD name VARCHAR(100) NOT NULL, DROP nom, CHANGE code code VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE media ADD type VARCHAR(255) NOT NULL, CHANGE discr media_type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112D61220EA6');
        $this->addSql('DROP INDEX IDX_D782112D61220EA6 ON playlist');
        $this->addSql('ALTER TABLE playlist ADD customer_id INT DEFAULT NULL, DROP creator_id');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112D9395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D782112D9395C3F3 ON playlist (customer_id)');
        $this->addSql('ALTER TABLE playlist_media CHANGE playlist_id playlist_id INT DEFAULT NULL, CHANGE media_id media_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE playlist_subscription DROP FOREIGN KEY FK_832940C7808B1AD');
        $this->addSql('DROP INDEX IDX_832940C7808B1AD ON playlist_subscription');
        $this->addSql('ALTER TABLE playlist_subscription ADD customer_id INT DEFAULT NULL, DROP subscriber_id, CHANGE playlist_id playlist_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE playlist_subscription ADD CONSTRAINT FK_832940C9395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_832940C9395C3F3 ON playlist_subscription (customer_id)');
        $this->addSql('ALTER TABLE season DROP FOREIGN KEY FK_F0E45BA9D94388BD');
        $this->addSql('DROP INDEX IDX_F0E45BA9D94388BD ON season');
        $this->addSql('ALTER TABLE season DROP number, CHANGE serie_id season_number INT NOT NULL');
        $this->addSql('ALTER TABLE subscription_history DROP FOREIGN KEY FK_54AF90D07808B1AD');
        $this->addSql('DROP INDEX IDX_54AF90D07808B1AD ON subscription_history');
        $this->addSql('ALTER TABLE subscription_history ADD start_date VARCHAR(255) NOT NULL, ADD end_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP subscriber_id, DROP start_at, DROP end_at, CHANGE subscription_id subscription_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` CHANGE username username VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE watch_history DROP FOREIGN KEY FK_DE44EFD8C300AB5D');
        $this->addSql('DROP INDEX IDX_DE44EFD8C300AB5D ON watch_history');
        $this->addSql('ALTER TABLE watch_history ADD customer_id INT DEFAULT NULL, DROP watcher_id, CHANGE media_id media_id INT DEFAULT NULL, CHANGE last_watched_at last_watched DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE watch_history ADD CONSTRAINT FK_DE44EFD89395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DE44EFD89395C3F3 ON watch_history (customer_id)');
    }
}
