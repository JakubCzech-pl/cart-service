<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240809200542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD phone_number VARCHAR(255) NOT NULL, ADD country_code VARCHAR(255) NOT NULL, ADD region_name VARCHAR(255) NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD postcode VARCHAR(255) NOT NULL, ADD street VARCHAR(255) NOT NULL, DROP person_first_name, DROP person_last_name, DROP person_phone_number, DROP region_country_code, DROP region_region_name, DROP region_city, DROP region_postcode, DROP street_street');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address ADD person_first_name VARCHAR(255) NOT NULL, ADD person_last_name VARCHAR(255) NOT NULL, ADD person_phone_number VARCHAR(255) NOT NULL, ADD region_country_code VARCHAR(255) NOT NULL, ADD region_region_name VARCHAR(255) NOT NULL, ADD region_city VARCHAR(255) NOT NULL, ADD region_postcode VARCHAR(255) NOT NULL, ADD street_street VARCHAR(255) NOT NULL, DROP first_name, DROP last_name, DROP phone_number, DROP country_code, DROP region_name, DROP city, DROP postcode, DROP street');
    }
}
