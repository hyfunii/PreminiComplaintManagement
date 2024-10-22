<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ComplaintCategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('complaint_categories')->insert([
            [
                'name' => 'Infrastruktur',
                'description' => 'Pengaduan mengenai permasalahan infrastruktur seperti jalan rusak',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Kesehatan',
                'description' => 'Pengaduan terkait layanan kesehatan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Layanan Publik',
                'description' => 'Pengaduan mengenai layanan publik',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
