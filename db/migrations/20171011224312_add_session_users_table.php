<?php


use Phinx\Migration\AbstractMigration;

class AddSessionUsersTable extends AbstractMigration
{
    public function up()
    {
        $users = $this->table('users');
        $users->addColumn('session_id', 'string')->save();
    }
}
