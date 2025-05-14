<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\User;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250401213052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Users table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable(User::TABLE_NAME);

        $table->addColumn(
            'id',
            Types::INTEGER,
            [
                'unsigned' => true,
                'autoincrement' => true,
                'notnull' => true,
            ]
        );
        $table->addColumn('first_name', Types::STRING, ['length' => 255]);
        $table->addColumn('last_name', Types::STRING, ['length' => 255]);
        $table->addColumn('patronymic', Types::STRING, ['length' => 255]);
        $table->addColumn('gender', Types::STRING, ['length' => 6]);
        $table->addColumn('user_type', Types::STRING, ['length' => 255]);
        $table->addColumn('email', Types::STRING, ['length' => 255]);
        // $table->addColumn('token', Types::TEXT);
        $table->addColumn('password', Types::STRING, ['length' => 255]);
        $table->addColumn('created_at', Types::DATETIME_IMMUTABLE);
        $table->addColumn('updated_at', Types::DATETIME_IMMUTABLE);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(User::TABLE_NAME);
    }
}
