<?php


use Phinx\Migration\AbstractMigration;

class SettingsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('global_settings');
        $table->addColumn('timeout_session', 'integer')
              ->addColumn('smtp_host', 'string', ['limit' => 100])
              ->addColumn('smtp_username', 'string')
              ->addColumn('smtp_password', 'string', ['limit' => 30])
              ->addColumn('smtp_port', 'string', ['limit' => 5])
              ->addTimestamps()
              ->create();
    }
}
