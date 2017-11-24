<?php


use Phinx\Seed\AbstractSeed;

class BooksSeeder extends AbstractSeed
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
        $books = $this->table('books');
        $books->truncate();

        $defaultBooks = [
            [
                'book_name' => 'O Codigo da Vinci',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'book_name' => 'Fortaleza Digital',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

        ];

        $books->insert($defaultBooks)->save();
    }
}
