<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            ComplaintCategoriesTableSeeder::class,
            ComplaintStatusesTableSeeder::class,
            ComplaintsTableSeeder::class,
            ResponsesTableSeeder::class,
            FilesTableSeeder::class,
        ]);
    }
}
