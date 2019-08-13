<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Table;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

class Version20190718070114 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $ruleTable = $this->createRuleTable($schema);
        $actionTable = $this->createActionTable($schema);
        $actionTypeTable = $this->createActionTypeTable($schema);
        $combinationTable = $this->createCombinationTable($schema);
        $conditionTable = $this->createConditionTable($schema);

        $ruleTable->addForeignKeyConstraint($combinationTable, ['combinationId'], ['id']);
        $ruleTable->addForeignKeyConstraint($actionTable, ['actionId'], ['id']);
        $actionTable->addForeignKeyConstraint($actionTypeTable, ['typeId'], ['id']);
        $actionTable->addForeignKeyConstraint($combinationTable, ['combinationId'], ['id']);
        $combinationTable->addForeignKeyConstraint($combinationTable, ['parentId'], ['id']);
        $conditionTable->addForeignKeyConstraint($combinationTable, ['combinationId'], ['id']);
    }

    /**
     * @param Schema $schema
     *
     * @return Table
     */
    private function createRuleTable(Schema $schema): Table
    {
        $ruleTable = $schema->createTable('rule');
        $ruleTable->addColumn('id', Type::INTEGER)->setAutoincrement(true);
        $ruleTable->addColumn('combinationId', Type::INTEGER);
        $ruleTable->addColumn('actionId', Type::INTEGER);
        $ruleTable->addColumn('active', Type::BOOLEAN);
        $ruleTable->addColumn('target', Type::STRING);
        $ruleTable->addColumn('dateFrom', Type::DATETIME)->setNotnull(false);
        $ruleTable->addColumn('dateTo', Type::DATETIME)->setNotnull(false);
        $ruleTable->addColumn('title', Type::TEXT);
        $ruleTable->addColumn('description', Type::TEXT)->setNotnull(false);
        $ruleTable->addColumn('priority', Type::INTEGER)->setNotnull(false);
        $ruleTable->setPrimaryKey(['id'])->addUniqueIndex(['combinationId', 'actionId']);

        return $ruleTable;
    }

    /**
     * @param Schema $schema
     *
     * @return Table
     */
    private function createActionTable(Schema $schema): Table
    {
        $actionTable = $schema->createTable('action');
        $actionTable->addColumn('id', Type::INTEGER)->setAutoincrement(true);
        $actionTable->addColumn('typeId', Type::INTEGER);
        $actionTable->addColumn('combinationId', Type::INTEGER)->setNotnull(false);
        $actionTable->addColumn('stopProcessing', Type::BOOLEAN);
        $actionTable->setPrimaryKey(['id']);

        return $actionTable;
    }

    /**
     * @param Schema $schema
     *
     * @return Table
     */
    private function createActionTypeTable(Schema $schema): Table
    {
        $actionTypeTable = $schema->createTable('action_type');
        $actionTypeTable->addColumn('id', Type::INTEGER)->setAutoincrement(true);
        $actionTypeTable->addColumn('code', Type::STRING);
        $actionTypeTable->addColumn('title', Type::STRING);
        $actionTypeTable->setPrimaryKey(['id']);

        return $actionTypeTable;
    }

    /**
     * @param Schema $schema
     *
     * @return Table
     */
    private function createCombinationTable(Schema $schema): Table
    {
        $combinationTable = $schema->createTable('combination');
        $combinationTable->addColumn('id', Type::INTEGER)->setAutoincrement(true);
        $combinationTable->addColumn('parentId', Type::INTEGER)->setNotnull(false);
        $combinationTable->addColumn('aggregator', Type::STRING);
        $combinationTable->addColumn('operator', Type::STRING)->setNotnull(false);
        $combinationTable->addColumn('value', Type::STRING);
        $combinationTable->setPrimaryKey(['id']);

        return $combinationTable;
    }

    /**
     * @param Schema $schema
     *
     * @return Table
     */
    private function createConditionTable(Schema $schema): Table
    {
        $conditionTable = $schema->createTable('condition');
        $conditionTable->addColumn('id', Type::INTEGER)->setAutoincrement(true);
        $conditionTable->addColumn('combinationId', Type::INTEGER);
        $conditionTable->addColumn('attribute', Type::STRING);
        $conditionTable->addColumn('operator', Type::STRING);
        $conditionTable->addColumn('value', Type::STRING);
        $conditionTable->setPrimaryKey(['id']);

        return $conditionTable;
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $schema->dropTable('rule');
        $schema->dropTable('action');
        $schema->dropTable('action_type');
        $schema->dropTable('combination');
        $schema->dropTable('condition');
    }
}