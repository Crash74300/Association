<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231018084300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE communication (id INT AUTO_INCREMENT NOT NULL, name_id INT NOT NULL, email_id INT NOT NULL, description VARCHAR(255) NOT NULL, photo_1 VARCHAR(255) DEFAULT NULL, photo_2 VARCHAR(255) DEFAULT NULL, photo_3 VARCHAR(255) DEFAULT NULL, photo_4 VARCHAR(255) DEFAULT NULL, INDEX IDX_F9AFB5EB71179CD6 (name_id), INDEX IDX_F9AFB5EBA832C1C9 (email_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE communication ADD CONSTRAINT FK_F9AFB5EB71179CD6 FOREIGN KEY (name_id) REFERENCES association (id)');
        $this->addSql('ALTER TABLE communication ADD CONSTRAINT FK_F9AFB5EBA832C1C9 FOREIGN KEY (email_id) REFERENCES association (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE communication DROP FOREIGN KEY FK_F9AFB5EB71179CD6');
        $this->addSql('ALTER TABLE communication DROP FOREIGN KEY FK_F9AFB5EBA832C1C9');
        $this->addSql('DROP TABLE communication');
    }
}
