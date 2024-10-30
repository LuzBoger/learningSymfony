<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241002150749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media CHANGE release_date release_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE subscription_history DROP FOREIGN KEY FK_54AF90D0DDE45DDE');
        $this->addSql('DROP INDEX IDX_54AF90D0DDE45DDE ON subscription_history');
        $this->addSql('ALTER TABLE subscription_history DROP current_subscription_id');
        $this->addSql('ALTER TABLE user ADD current_subscription_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649DDE45DDE FOREIGN KEY (current_subscription_id) REFERENCES subscription_history (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649DDE45DDE ON user (current_subscription_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media CHANGE release_date release_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE subscription_history ADD current_subscription_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE subscription_history ADD CONSTRAINT FK_54AF90D0DDE45DDE FOREIGN KEY (current_subscription_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_54AF90D0DDE45DDE ON subscription_history (current_subscription_id)');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649DDE45DDE');
        $this->addSql('DROP INDEX IDX_8D93D649DDE45DDE ON `user`');
        $this->addSql('ALTER TABLE `user` DROP current_subscription_id');
    }
}
