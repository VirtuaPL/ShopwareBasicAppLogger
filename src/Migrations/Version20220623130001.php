<?php

declare(strict_types=1);

namespace Virtua\ShopwareAppLoggerBundle\Migrations;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Psr\Log\LoggerInterface;

final class Version20220623130001 extends AbstractMigration
{
    private LoggerInterface $logger;

    public function __construct(Connection $connection, LoggerInterface $logger)
    {
        parent::__construct($connection, $logger);
        $this->connection = $connection;
        $this->logger = $logger;
    }

    public function getDescription(): string
    {
        return 'Add ';
    }

    public function up(Schema $schema): void
    {
        $alterSql = <<<SQL
            ALTER TABLE shopware_app_log 
            ADD COLUMN entity_name VARCHAR(32) DEFAULT NULL
        SQL;

        if (!$schema->hasTable('shopware_app_log')) {
            $tableMigration = new Version20220530129996($this->connection, $this->logger);
            $tableMigration->up($schema);
            $this->addSql($tableMigration->getSql()[0]->getStatement());
            $this->alterTable($alterSql);

            return;
        }

        if ($schema->hasTable('shopware_app_log')) {
            $this->addSql($alterSql);
        }
    }

    public function down(Schema $schema): void
    {
    }
}
