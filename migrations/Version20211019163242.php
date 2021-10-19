<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211019163242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add relation FeeSheet, State';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fee_sheet ADD state_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fee_sheet ADD CONSTRAINT FK_3433FDC05D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
        $this->addSql('CREATE INDEX IDX_3433FDC05D83CC1 ON fee_sheet (state_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fee_sheet DROP FOREIGN KEY FK_3433FDC05D83CC1');
        $this->addSql('DROP INDEX IDX_3433FDC05D83CC1 ON fee_sheet');
        $this->addSql('ALTER TABLE fee_sheet DROP state_id');
    }
}
