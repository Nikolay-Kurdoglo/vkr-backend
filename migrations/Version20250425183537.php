<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Product;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

final class Version20250425183537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Product';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable(Product::TABLE_NAME);

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
        $table->addColumn('title', Types::STRING, ['length' => 255]);
        $table->addColumn('description', Types::TEXT);
        $table->addColumn('price', Types::FLOAT);
        $table->addColumn('quantity', Types::INTEGER);
        $table->addColumn('measure', Types::INTEGER);
        $table->addColumn('rate', Types::FLOAT);
        $table->addColumn('category', Types::STRING);
        $table->addColumn('weight', Types::FLOAT);
        $table->addColumn('sku', Types::INTEGER);
        $table->addColumn('warehouse_address', Types::STRING);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(Product::TABLE_NAME);
    }
}
