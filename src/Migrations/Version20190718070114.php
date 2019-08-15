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

        $foreignKeyOptions = ['onDelete' => 'CASCADE'];
        $actionTable->addForeignKeyConstraint($ruleTable, ['ruleId'], ['id'], $foreignKeyOptions);
        $actionTable->addForeignKeyConstraint($actionTypeTable, ['typeId'], ['id']);
        $combinationTable->addForeignKeyConstraint($ruleTable, ['ruleId'], ['id'], $foreignKeyOptions);
        $combinationTable->addForeignKeyConstraint($actionTable, ['actionId'], ['id'], $foreignKeyOptions);
        $combinationTable->addForeignKeyConstraint($combinationTable, ['parentId'], ['id'], $foreignKeyOptions);
        $conditionTable->addForeignKeyConstraint($combinationTable, ['combinationId'], ['id'], $foreignKeyOptions);
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
        $ruleTable->addColumn('active', Type::BOOLEAN);
        $ruleTable->addColumn('target', Type::STRING);
        $ruleTable->addColumn('dateFrom', Type::DATETIME)->setNotnull(false);
        $ruleTable->addColumn('dateTo', Type::DATETIME)->setNotnull(false);
        $ruleTable->addColumn('title', Type::TEXT);
        $ruleTable->addColumn('description', Type::TEXT)->setNotnull(false);
        $ruleTable->addColumn('priority', Type::INTEGER)->setNotnull(false);
        $ruleTable->setPrimaryKey(['id']);

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
        $actionTable->addColumn('ruleId', Type::INTEGER);
        $actionTable->addColumn('typeId', Type::INTEGER);
        $actionTable->addColumn('stopProcessing', Type::BOOLEAN)->setDefault(false);
        $actionTable->setPrimaryKey(['id'])->addUniqueIndex(['ruleId']);

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
        $combinationTable->addColumn('ruleId', Type::INTEGER)->setNotnull(false);
        $combinationTable->addColumn('actionId', Type::INTEGER)->setNotnull(false);
        $combinationTable->addColumn('parentId', Type::INTEGER)->setNotnull(false);
        $combinationTable->addColumn('aggregator', Type::STRING);
        $combinationTable->addColumn('value', Type::STRING);
        $combinationTable->setPrimaryKey(['id'])->addUniqueIndex(['ruleId', 'actionId']);

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
