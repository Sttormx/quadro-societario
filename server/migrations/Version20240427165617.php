<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240427165617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create companies_partners';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE companies_partners (
            id SERIAL PRIMARY KEY,
            company_id INT NOT NULL,
            partner_id INT NOT NULL,
            created_at TIMESTAMP WITHOUT TIME ZONE NOT NULL,
            updated_at TIMESTAMP WITHOUT TIME ZONE DEFAULT NULL,
            deleted_at TIMESTAMP WITHOUT TIME ZONE DEFAULT NULL,
            CONSTRAINT fk_company
                FOREIGN KEY (company_id)
                REFERENCES companies (id)
                ON DELETE CASCADE,
            CONSTRAINT fk_partner
                FOREIGN KEY (partner_id)
                REFERENCES partners (id)
                ON DELETE CASCADE
        );');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE companies_partners');
    }
}
