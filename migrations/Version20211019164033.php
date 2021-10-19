<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211019164033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add relation FeeSheet,StandardFeesLine';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE standard_fees_line ADD fee_sheets_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE standard_fees_line ADD CONSTRAINT FK_E403738ADF40534C FOREIGN KEY (fee_sheets_id) REFERENCES fee_sheet (id)');
        $this->addSql('CREATE INDEX IDX_E403738ADF40534C ON standard_fees_line (fee_sheets_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE standard_fees_line DROP FOREIGN KEY FK_E403738ADF40534C');
        $this->addSql('DROP INDEX IDX_E403738ADF40534C ON standard_fees_line');
        $this->addSql('ALTER TABLE standard_fees_line DROP fee_sheets_id');
    }
}
