<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FilesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('files')->insert([
            [
                'complaint_id' => 1, // Pengaduan Jalan Berlubang
                'file_path' => '/files/jalan-berlubang.jpg',
                'file_type' => 'image',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
