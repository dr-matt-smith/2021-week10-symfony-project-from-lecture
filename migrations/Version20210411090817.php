<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210411090817 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE timber (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bed ADD timber_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bed ADD CONSTRAINT FK_E647FCFF225B329B FOREIGN KEY (timber_id) REFERENCES timber (id)');
        $this->addSql('CREATE INDEX IDX_E647FCFF225B329B ON bed (timber_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bed DROP FOREIGN KEY FK_E647FCFF225B329B');
        $this->addSql('DROP TABLE timber');
        $this->addSql('DROP INDEX IDX_E647FCFF225B329B ON bed');
        $this->addSql('ALTER TABLE bed DROP timber_id');
    }
}
