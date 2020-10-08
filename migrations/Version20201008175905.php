<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201008175905 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercise (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, intervals INT NOT NULL, is_private TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercise_exercise_tag (exercise_id INT NOT NULL, exercise_tag_id INT NOT NULL, INDEX IDX_7F4EA7D6E934951A (exercise_id), INDEX IDX_7F4EA7D6CF9DF67A (exercise_tag_id), PRIMARY KEY(exercise_id, exercise_tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercise_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_private TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, tracks LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', is_private TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE track (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, author VARCHAR(255) DEFAULT NULL, is_private TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE track_track_tag (track_id INT NOT NULL, track_tag_id INT NOT NULL, INDEX IDX_866EB3F25ED23C43 (track_id), INDEX IDX_866EB3F2F210A2F8 (track_tag_id), PRIMARY KEY(track_id, track_tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE track_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_private TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workout (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, duration INT NOT NULL, exercises LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', is_private TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercise_exercise_tag ADD CONSTRAINT FK_7F4EA7D6E934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercise_exercise_tag ADD CONSTRAINT FK_7F4EA7D6CF9DF67A FOREIGN KEY (exercise_tag_id) REFERENCES exercise_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE track_track_tag ADD CONSTRAINT FK_866EB3F25ED23C43 FOREIGN KEY (track_id) REFERENCES track (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE track_track_tag ADD CONSTRAINT FK_866EB3F2F210A2F8 FOREIGN KEY (track_tag_id) REFERENCES track_tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise_exercise_tag DROP FOREIGN KEY FK_7F4EA7D6E934951A');
        $this->addSql('ALTER TABLE exercise_exercise_tag DROP FOREIGN KEY FK_7F4EA7D6CF9DF67A');
        $this->addSql('ALTER TABLE track_track_tag DROP FOREIGN KEY FK_866EB3F25ED23C43');
        $this->addSql('ALTER TABLE track_track_tag DROP FOREIGN KEY FK_866EB3F2F210A2F8');
        $this->addSql('DROP TABLE exercise');
        $this->addSql('DROP TABLE exercise_exercise_tag');
        $this->addSql('DROP TABLE exercise_tag');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE track');
        $this->addSql('DROP TABLE track_track_tag');
        $this->addSql('DROP TABLE track_tag');
        $this->addSql('DROP TABLE workout');
    }
}
