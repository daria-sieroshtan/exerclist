<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201014200557 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise_tag ADD CONSTRAINT FK_95D612FFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_95D612FFA76ED395 ON exercise_tag (user_id)');
        $this->addSql('ALTER TABLE playlist ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D782112DA76ED395 ON playlist (user_id)');
        $this->addSql('ALTER TABLE track ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE track ADD CONSTRAINT FK_D6E3F8A6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6A76ED395 ON track (user_id)');
        $this->addSql('ALTER TABLE track_tag ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE track_tag ADD CONSTRAINT FK_87D61D06A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_87D61D06A76ED395 ON track_tag (user_id)');
        $this->addSql('ALTER TABLE workout ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE workout ADD CONSTRAINT FK_649FFB72A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_649FFB72A76ED395 ON workout (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise_tag DROP FOREIGN KEY FK_95D612FFA76ED395');
        $this->addSql('DROP INDEX IDX_95D612FFA76ED395 ON exercise_tag');
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112DA76ED395');
        $this->addSql('DROP INDEX IDX_D782112DA76ED395 ON playlist');
        $this->addSql('ALTER TABLE playlist DROP user_id');
        $this->addSql('ALTER TABLE track DROP FOREIGN KEY FK_D6E3F8A6A76ED395');
        $this->addSql('DROP INDEX IDX_D6E3F8A6A76ED395 ON track');
        $this->addSql('ALTER TABLE track DROP user_id');
        $this->addSql('ALTER TABLE track_tag DROP FOREIGN KEY FK_87D61D06A76ED395');
        $this->addSql('DROP INDEX IDX_87D61D06A76ED395 ON track_tag');
        $this->addSql('ALTER TABLE track_tag DROP user_id');
        $this->addSql('ALTER TABLE workout DROP FOREIGN KEY FK_649FFB72A76ED395');
        $this->addSql('DROP INDEX IDX_649FFB72A76ED395 ON workout');
        $this->addSql('ALTER TABLE workout DROP user_id');
    }
}
