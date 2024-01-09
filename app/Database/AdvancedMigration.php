<?php namespace App\Database;

use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Database\Migration;

/**
 * Class AdvancedMigration
 *
 * @package App\Database
 * @author Manuel Piton (Redsky Thirty)
 */
abstract class AdvancedMigration extends Migration
{
    /**
     * Perform a migration step.
     */
    abstract public function up();

    /**
     * Perform a migration step.
     */
    abstract public function down();


    /**
     * @param string $tableName
     * @param string $fieldName
     * @param string $relatedTableName
     * @param string $relatedTableField
     * @param string $onUpdate
     * @param string $onDelete
     * @param string $indexMethod
     * @return bool
     */
    protected function addNewForeignKey(
        string $tableName = '',
        string $fieldName = '',
        string $relatedTableName = '',
        string $relatedTableField = '',
        string $onUpdate = '',
        string $onDelete = '',
        string $indexMethod = 'btree'
    ): bool
    {
        if (!$this->db->simpleQuery('ALTER TABLE `'.$tableName.'` ADD CONSTRAINT `'.$tableName.'_'.$fieldName.'_foreign` FOREIGN KEY (`'.$fieldName.'`) REFERENCES `'.$relatedTableName.'` (`'.$relatedTableField.'`) ON DELETE '.strtoupper($onDelete).' ON UPDATE '.strtoupper($onUpdate).';'))
        {
            $error = $this->db->error();

            throw new DatabaseException('An error occured in "AdvancedMigration" (1).\nCode: '.$error['code'].'\nMessage: '.$error['message']);
        }

        if (empty($error))
        {
            if (!$this->db->simpleQuery('ALTER TABLE `'.$tableName.'` ADD INDEX `'.$tableName.'_'.$fieldName.'_foreign`(`'.$fieldName.'`) USING '.strtoupper($indexMethod).';'))
            {
                $error = $this->db->error();

                throw new DatabaseException('An error occured in "AdvancedMigration" (2).\nCode: '.$error['code'].'\nMessage: '.$error['message']);
            }
        }

        return true;
    }
}