<?php

declare(strict_types=1);

namespace Virtua\ShopwareAppLoggerBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220530129996 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $createSql = <<<SQL
            CREATE TABLE shopware_app_log (
                id INT AUTO_INCREMENT NOT NULL, 
                shopware_shop_id INT NOT NULL, 
                error_code INT NOT NULL, 
                error_message LONGTEXT NOT NULL, 
                created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', 
                INDEX IDX_3B74D015B092A811 (shopware_shop_id), 
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL;

        $alterSql = <<<SQL
            ALTER TABLE shopware_app_log 
            ADD CONSTRAINT FK_3B74D015B092A811 
            FOREIGN KEY (shopware_shop_id) 
            REFERENCES shopware_shop (id)
        SQL;

        if (!$schema->hasTable('shopware_app_log')) {
            $this->addSql($createSql);
            $this->addSql($alterSql);
        }
    }

    public function down(Schema $schema): void
    {
    }
}
