<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190408071712 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE divers (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, quantite INT NOT NULL, couleur VARCHAR(255) DEFAULT NULL, format VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emplacement (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, support_id INT DEFAULT NULL, date DATETIME NOT NULL, action VARCHAR(255) NOT NULL, quantite INT NOT NULL, INDEX IDX_EDBFD5ECA76ED395 (user_id), INDEX IDX_EDBFD5EC315B405 (support_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liquide (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, quantite INT NOT NULL, couleur VARCHAR(255) DEFAULT NULL, format VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE support (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, quantite INT NOT NULL, couleur VARCHAR(255) DEFAULT NULL, format VARCHAR(255) DEFAULT NULL, grammage INT DEFAULT NULL, materiel VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5EC315B405 FOREIGN KEY (support_id) REFERENCES support (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5EC315B405');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5ECA76ED395');
        $this->addSql('DROP TABLE divers');
        $this->addSql('DROP TABLE emplacement');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE liquide');
        $this->addSql('DROP TABLE support');
        $this->addSql('DROP TABLE user');
    }
}
