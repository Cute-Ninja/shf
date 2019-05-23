<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190523091509 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, status VARCHAR(50) NOT NULL, created_date DATETIME NOT NULL, updated_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workout_step (id INT AUTO_INCREMENT NOT NULL, workout_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, status VARCHAR(50) NOT NULL, created_date DATETIME NOT NULL, updated_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_3B37FD405E237E06 (name), INDEX IDX_3B37FD40A6CCCFC9 (workout_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workout (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, status VARCHAR(50) NOT NULL, created_date DATETIME NOT NULL, updated_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_649FFB725E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, user_stats_id INT DEFAULT NULL, username VARCHAR(75) NOT NULL, email VARCHAR(150) NOT NULL, password VARCHAR(255) NOT NULL, is_admin TINYINT(1) NOT NULL, confirmation_key VARCHAR(255) DEFAULT NULL, confirmation_key_expiration DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', status VARCHAR(50) NOT NULL, created_date DATETIME NOT NULL, updated_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649704B0348 (confirmation_key), UNIQUE INDEX UNIQ_8D93D6499027D082 (user_stats_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_stats (id INT AUTO_INCREMENT NOT NULL, distance_total DOUBLE PRECISION NOT NULL, distance_of_the_week DOUBLE PRECISION NOT NULL, calories_total INT NOT NULL, calories_of_the_week INT NOT NULL, status VARCHAR(50) NOT NULL, created_date DATETIME NOT NULL, updated_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, status VARCHAR(50) NOT NULL, created_date DATETIME NOT NULL, updated_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_1A85EFD25E237E06 (name), INDEX IDX_1A85EFD2727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, sport_id INT DEFAULT NULL, started_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, status VARCHAR(50) NOT NULL, created_date DATETIME NOT NULL, updated_date DATETIME NOT NULL, INDEX IDX_D044D5D4A76ED395 (user_id), INDEX IDX_D044D5D4AC78BCF8 (sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE workout_step ADD CONSTRAINT FK_3B37FD40A6CCCFC9 FOREIGN KEY (workout_id) REFERENCES workout (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499027D082 FOREIGN KEY (user_stats_id) REFERENCES user_stats (id)');
        $this->addSql('ALTER TABLE sport ADD CONSTRAINT FK_1A85EFD2727ACA70 FOREIGN KEY (parent_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE workout_step DROP FOREIGN KEY FK_3B37FD40A6CCCFC9');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4A76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499027D082');
        $this->addSql('ALTER TABLE sport DROP FOREIGN KEY FK_1A85EFD2727ACA70');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4AC78BCF8');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE workout_step');
        $this->addSql('DROP TABLE workout');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_stats');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE session');
    }
}
