<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240427052238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create companies migration.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE companies (
            id SERIAL PRIMARY KEY,
            uuid UUID NOT NULL UNIQUE,
            name VARCHAR(255) NOT NULL,
            document VARCHAR(255) NOT NULL,
            created_at TIMESTAMP WITHOUT TIME ZONE NOT NULL,
            updated_at TIMESTAMP WITHOUT TIME ZONE DEFAULT NULL,
            deleted_at TIMESTAMP WITHOUT TIME ZONE DEFAULT NULL
        );');

        $this->addSql("
            INSERT INTO public.user (id,email,roles,password) VALUES (1,'admin@admin.com','{}','\$2y\$13\$buUPEGKzk1V2Krm8nchUT.JHnwbhL79Ec8afkefMCyMD/m8ibK2AG');
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE companies');
    }
}
