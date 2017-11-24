<?php


use Phinx\Seed\AbstractSeed;

class SettingsSeeder extends AbstractSeed
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
        $settings = $this->table('global_settings');
        $settings->truncate();

        $defaultsettings = [
            [
                'timeout_session' => 10,
                'smtp_host' => 'mail.felipematos.com',
                'smtp_username' => 'felipe.moreira@f2mtecnologia.com.br',
                'smtp_password' => 'Patemo3l',
                'smtp_port' => '465',
            ],
        ];

        $settings->insert($defaultsettings)->save();
    }
}
