<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201215082933 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, creation_date DATETIME NOT NULL, prix DOUBLE PRECISION NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_F5299398A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_details (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, commande_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_845CA2C1F347EFB (produit_id), INDEX IDX_845CA2C182EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE order_details ADD CONSTRAINT FK_845CA2C1F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE order_details ADD CONSTRAINT FK_845CA2C182EA2E54 FOREIGN KEY (commande_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE adresse_livraison CHANGE user_id user_id INT DEFAULT NULL, CHANGE societe societe VARCHAR(255) DEFAULT NULL, CHANGE adresse_suite adresse_suite VARCHAR(255) DEFAULT NULL, CHANGE tel_fix tel_fix VARCHAR(15) DEFAULT NULL, CHANGE tel_mobile tel_mobile VARCHAR(15) DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie CHANGE image image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE produit CHANGE annee annee VARCHAR(20) DEFAULT NULL, CHANGE cepage cepage VARCHAR(255) DEFAULT NULL, CHANGE exposition_soleil exposition_soleil VARCHAR(255) DEFAULT NULL, CHANGE methodes_vendanges methodes_vendanges VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_details DROP FOREIGN KEY FK_845CA2C182EA2E54');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_details');
        $this->addSql('ALTER TABLE adresse_livraison CHANGE user_id user_id INT DEFAULT NULL, CHANGE societe societe VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE adresse_suite adresse_suite VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE tel_fix tel_fix VARCHAR(15) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE tel_mobile tel_mobile VARCHAR(15) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE categorie CHANGE image image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE produit CHANGE annee annee VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE cepage cepage VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE exposition_soleil exposition_soleil VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE methodes_vendanges methodes_vendanges VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
