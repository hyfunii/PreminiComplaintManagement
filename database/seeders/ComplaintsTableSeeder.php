<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ComplaintsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('complaints')->insert([
            [
                'user_id' => 2, // Assuming John Doe (user)
                'category_id' => 1, // Infrastruktur
                'status_id' => 1, // Diajukan
                'title' => 'Jalan Berlubang di Daerah A',
                'description' => 'Jalan berlubang di daerah A sangat berbahaya bagi pengendara.',
                'file_path' => '/files/jalan-berlubang.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
