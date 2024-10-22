<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ResponsesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('responses')->insert([
            [
                'complaint_id' => 1, // Pengaduan Jalan Berlubang
                'admin_id' => 1, // Admin
                'response_text' => 'Pengaduan Anda sedang diproses, tim akan segera turun ke lapangan.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
