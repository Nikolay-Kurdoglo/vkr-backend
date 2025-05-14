<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Order;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250509214809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Orders';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable(Order::TABLE_NAME);

        $table
            ->addColumn(
                'id',
                Types::INTEGER,
                [
                    'autoincrement' => true,
                    'unsigned' => true,
                    'notnull' => true,
                ],
            );
        $table->addColumn('code', Types::INTEGER);
        $table->addColumn('customer', Types::STRING);
        $table->addColumn('line_items_count', Types::INTEGER);
        $table->addColumn('status', Types::INTEGER);
        $table->addColumn('order_picker', Types::STRING);
        $table->addColumn('total_price', Types::FLOAT);
        $table->addColumn('date', Types::DATE_MUTABLE);
        $table->addColumn('responsible_support', Types::STRING);
        $table->addColumn('email', Types::STRING);
        $table->addColumn('phone', Types::BIGINT);

    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(Order::TABLE_NAME);
    }
}
