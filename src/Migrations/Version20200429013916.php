<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200429013916 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, date_entered DATETIME NOT NULL, status VARCHAR(255) NOT NULL, total_amount NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pizza ADD orders_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pizza ADD CONSTRAINT FK_CFDD826FCFFE9AD6 FOREIGN KEY (orders_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_CFDD826FCFFE9AD6 ON pizza (orders_id)');
        $this->addSql('ALTER TABLE topping ADD pizza_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE topping ADD CONSTRAINT FK_81AA94E7D41D1D42 FOREIGN KEY (pizza_id) REFERENCES pizza (id)');
        $this->addSql('CREATE INDEX IDX_81AA94E7D41D1D42 ON topping (pizza_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pizza DROP FOREIGN KEY FK_CFDD826FCFFE9AD6');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP INDEX IDX_CFDD826FCFFE9AD6 ON pizza');
        $this->addSql('ALTER TABLE pizza DROP orders_id');
        $this->addSql('ALTER TABLE topping DROP FOREIGN KEY FK_81AA94E7D41D1D42');
        $this->addSql('DROP INDEX IDX_81AA94E7D41D1D42 ON topping');
        $this->addSql('ALTER TABLE topping DROP pizza_id');
    }
}
