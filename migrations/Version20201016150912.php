<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201016150912 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE exercise_tag ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE playlist ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE track ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE track_tag ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE workout ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise DROP created, DROP updated');
        $this->addSql('ALTER TABLE exercise_tag DROP created, DROP updated');
        $this->addSql('ALTER TABLE playlist DROP created, DROP updated');
        $this->addSql('ALTER TABLE track DROP created, DROP updated');
        $this->addSql('ALTER TABLE track_tag DROP created, DROP updated');
        $this->addSql('ALTER TABLE workout DROP created, DROP updated');
    }
}
