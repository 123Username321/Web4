<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200512223058 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE feedbacks (id INT NOT NULL, product_id_id INT NOT NULL, user_id_id INT NOT NULL, content VARCHAR(255) NOT NULL, raiting INT NOT NULL, add_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7E6C3F89DE18E50B ON feedbacks (product_id_id)');
        $this->addSql('CREATE INDEX IDX_7E6C3F899D86650F ON feedbacks (user_id_id)');
        $this->addSql('CREATE TABLE products (id INT NOT NULL, name VARCHAR(80) NOT NULL, description VARCHAR(255) NOT NULL, add_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, raiting DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(40) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('ALTER TABLE feedbacks ADD CONSTRAINT FK_7E6C3F89DE18E50B FOREIGN KEY (product_id_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feedbacks ADD CONSTRAINT FK_7E6C3F899D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE feedbacks DROP CONSTRAINT FK_7E6C3F89DE18E50B');
        $this->addSql('ALTER TABLE feedbacks DROP CONSTRAINT FK_7E6C3F899D86650F');
        $this->addSql('DROP TABLE feedbacks');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE users');
    }
}
