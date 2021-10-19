<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211019165009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add relation FeeSheet, VariableFeesLine';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE variable_fees_line ADD fee_sheet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE variable_fees_line ADD CONSTRAINT FK_AA26016BE92CADA2 FOREIGN KEY (fee_sheet_id) REFERENCES fee_sheet (id)');
        $this->addSql('CREATE INDEX IDX_AA26016BE92CADA2 ON variable_fees_line (fee_sheet_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE variable_fees_line DROP FOREIGN KEY FK_AA26016BE92CADA2');
        $this->addSql('DROP INDEX IDX_AA26016BE92CADA2 ON variable_fees_line');
        $this->addSql('ALTER TABLE variable_fees_line DROP fee_sheet_id');
    }
}
