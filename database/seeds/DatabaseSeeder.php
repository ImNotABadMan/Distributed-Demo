<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $lastId = \App\Libs\DbConnection::connection(2)->table('users')
            ->latest('id')->limit(1)->first(['id']);

        $lastId = is_null($lastId) ? 1 : $lastId->id + 1;

        foreach (range($lastId, $lastId + 40) as $id) {
            factory(\App\User::class,1)
                ->connection(\App\Libs\DbConnection::subConnectName($id))
                ->create(['id' => $id]);
        }
    }
}
