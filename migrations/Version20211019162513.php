<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211019162513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add relation EmployeeType ,Employee';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee ADD employee_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A14500DA9C FOREIGN KEY (employee_type_id) REFERENCES employee_type (id)');
        $this->addSql('CREATE INDEX IDX_5D9F75A14500DA9C ON employee (employee_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A14500DA9C');
        $this->addSql('DROP INDEX IDX_5D9F75A14500DA9C ON employee');
        $this->addSql('ALTER TABLE employee DROP employee_type_id');
    }
}
