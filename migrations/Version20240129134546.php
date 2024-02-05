<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240129134546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(sql:'ALTER TABLE picture ADD restaurant_id INT NOT NULL');
        $this->addSql(sql:'ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql(sql:'CREATE INDEX IDX_16DB4F89B1E7706E ON picture (restaurant_id)');
        
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(sql:'ALTER TABLE picture DROP FOREIGN KEY  K_16DB4F89B1E7706E');
        $this->addSql(sql:'DROP INDEX IDX_16DB4F89B1E7706E ON picture');
        $this->addSql(sql:'ALTER TABLE picture DROP restaurant_id');
    }
}
