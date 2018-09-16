<?php


use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $users = $this->table('users');
	$this->execute('SET foreign_key_checks=0');   
	$users->truncate();
        $this->execute('SET foreign_key_checks=1');        

        $defaultUsers = [
            [
                'user' => 'admin',
                'hash' => password_hash('admin', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $users->insert($defaultUsers)->save();
    }
}
