<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211019162855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add relation Employee, FeeSheet';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fee_sheet ADD employees_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fee_sheet ADD CONSTRAINT FK_3433FDC08520A30B FOREIGN KEY (employees_id) REFERENCES employee (id)');
        $this->addSql('CREATE INDEX IDX_3433FDC08520A30B ON fee_sheet (employees_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fee_sheet DROP FOREIGN KEY FK_3433FDC08520A30B');
        $this->addSql('DROP INDEX IDX_3433FDC08520A30B ON fee_sheet');
        $this->addSql('ALTER TABLE fee_sheet DROP employees_id');
    }
}
