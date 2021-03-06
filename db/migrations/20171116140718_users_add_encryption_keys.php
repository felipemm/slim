<?php


use Phinx\Migration\AbstractMigration;

class UsersAddEncryptionKeys extends AbstractMigration
{
    public function up()
    {
        $users = $this->table('users');
        $users->addColumn('user_sealed_encryption_key', 'text', ['null' => true])
              ->addColumn('user_pwd_encrypted_pkey', 'text', ['null' => true])
              ->addColumn('user_env_key', 'text', ['null' => true])
              ->save();

    }
}
