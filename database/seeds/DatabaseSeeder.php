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
        $users = factory(App\Client::class, 1000)->create();
        $users = factory(App\Project::class, 1000)->create();

        // $this->call(UsersTableSeeder::class);
        // $this->call(ClientsTableSeeder::class);
        // $this->call(ProjectsTableSeeder::class);
    }
}
