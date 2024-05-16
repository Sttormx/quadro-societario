<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240427164933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create partners table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE partners (
            id SERIAL PRIMARY KEY,
            uuid UUID NOT NULL UNIQUE,
            name VARCHAR(255) NOT NULL,
            document VARCHAR(255) NOT NULL,
            created_at TIMESTAMP WITHOUT TIME ZONE NOT NULL,
            updated_at TIMESTAMP WITHOUT TIME ZONE DEFAULT NULL,
            deleted_at TIMESTAMP WITHOUT TIME ZONE DEFAULT NULL
        );');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE partners');
    }
}
