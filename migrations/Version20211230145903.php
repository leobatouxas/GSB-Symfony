<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211230145903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, employee_type_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postalcode VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5D9F75A1F85E0677 (username), INDEX IDX_5D9F75A14500DA9C (employee_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fee_sheet (id INT AUTO_INCREMENT NOT NULL, state_id INT DEFAULT NULL, employee_id INT DEFAULT NULL, date DATE NOT NULL, nb_documents INT NOT NULL, valid_amount DOUBLE PRECISION NOT NULL, INDEX IDX_3433FDC05D83CC1 (state_id), INDEX IDX_3433FDC08C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE standard_fees (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, unit_amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE standard_fees_line (id INT AUTO_INCREMENT NOT NULL, standard_fees_id INT DEFAULT NULL, fee_sheet_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_E403738AB7CE3D73 (standard_fees_id), INDEX IDX_E403738AE92CADA2 (fee_sheet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variable_fees_line (id INT AUTO_INCREMENT NOT NULL, fee_sheet_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, date DATE NOT NULL, amount DOUBLE PRECISION NOT NULL, INDEX IDX_AA26016BE92CADA2 (fee_sheet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A14500DA9C FOREIGN KEY (employee_type_id) REFERENCES employee_type (id)');
        $this->addSql('ALTER TABLE fee_sheet ADD CONSTRAINT FK_3433FDC05D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
        $this->addSql('ALTER TABLE fee_sheet ADD CONSTRAINT FK_3433FDC08C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE standard_fees_line ADD CONSTRAINT FK_E403738AB7CE3D73 FOREIGN KEY (standard_fees_id) REFERENCES standard_fees (id)');
        $this->addSql('ALTER TABLE standard_fees_line ADD CONSTRAINT FK_E403738AE92CADA2 FOREIGN KEY (fee_sheet_id) REFERENCES fee_sheet (id)');
        $this->addSql('ALTER TABLE variable_fees_line ADD CONSTRAINT FK_AA26016BE92CADA2 FOREIGN KEY (fee_sheet_id) REFERENCES fee_sheet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fee_sheet DROP FOREIGN KEY FK_3433FDC08C03F15C');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A14500DA9C');
        $this->addSql('ALTER TABLE standard_fees_line DROP FOREIGN KEY FK_E403738AE92CADA2');
        $this->addSql('ALTER TABLE variable_fees_line DROP FOREIGN KEY FK_AA26016BE92CADA2');
        $this->addSql('ALTER TABLE standard_fees_line DROP FOREIGN KEY FK_E403738AB7CE3D73');
        $this->addSql('ALTER TABLE fee_sheet DROP FOREIGN KEY FK_3433FDC05D83CC1');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE employee_type');
        $this->addSql('DROP TABLE fee_sheet');
        $this->addSql('DROP TABLE standard_fees');
        $this->addSql('DROP TABLE standard_fees_line');
        $this->addSql('DROP TABLE state');
        $this->addSql('DROP TABLE variable_fees_line');
    }
}
