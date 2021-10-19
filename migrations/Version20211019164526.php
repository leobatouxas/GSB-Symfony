<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211019164526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add relation StandardFeesLine,StandardFees';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE standard_fees_line ADD standard_fees_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE standard_fees_line ADD CONSTRAINT FK_E403738AB7CE3D73 FOREIGN KEY (standard_fees_id) REFERENCES standard_fees (id)');
        $this->addSql('CREATE INDEX IDX_E403738AB7CE3D73 ON standard_fees_line (standard_fees_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE standard_fees_line DROP FOREIGN KEY FK_E403738AB7CE3D73');
        $this->addSql('DROP INDEX IDX_E403738AB7CE3D73 ON standard_fees_line');
        $this->addSql('ALTER TABLE standard_fees_line DROP standard_fees_id');
    }
}
