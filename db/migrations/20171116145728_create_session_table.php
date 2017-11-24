<?php


use Phinx\Migration\AbstractMigration;

class CreateSessionTable extends AbstractMigration
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
        $table = $this->table('sessions');
        $table->addColumn('user_id', 'integer')
              ->addColumn('session_id', 'string')
              ->addColumn('auth_hash', 'string')
              ->addColumn('created_at', 'datetime')
              ->addcolumn('updated_at', 'datetime')
              ->addcolumn('ended_at', 'datetime')
              ->addForeignKey('user_id', 'users', 'id')
              ->create();
    }
}
