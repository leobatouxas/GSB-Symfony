<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211201101557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Passage de integer à double';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fee_sheet CHANGE valid_amount valid_amount DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE standard_fees CHANGE unit_amount unit_amount DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE variable_fees_line CHANGE amount amount DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fee_sheet CHANGE valid_amount valid_amount INT NOT NULL');
        $this->addSql('ALTER TABLE standard_fees CHANGE unit_amount unit_amount INT NOT NULL');
        $this->addSql('ALTER TABLE variable_fees_line CHANGE amount amount INT NOT NULL');
    }
}
