<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ComplaintStatusesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('complaint_statuses')->insert([
            [
                'name' => 'Submitted',
                'description' => 'New complaints have been submitted by users',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Prossesed',
                'description' => 'The complaint is in the process of being handled',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Done',
                'description' => 'The complaint has been handled',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
