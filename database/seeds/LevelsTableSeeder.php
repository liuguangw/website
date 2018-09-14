<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createdAt = now();
        DB::table('levels')->insert([
            ['name' => '1级', 'min_exp' => 0, 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => '2级', 'min_exp' => 11, 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => '3级', 'min_exp' => 101, 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => '4级', 'min_exp' => 501, 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => '5级', 'min_exp' => 2001, 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => '6级', 'min_exp' => 5501, 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => '7级', 'min_exp' => 14001, 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => '8级', 'min_exp' => 31001, 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => '9级', 'min_exp' => 61001, 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => '10级', 'min_exp' => 110001, 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => '11级', 'min_exp' => 185001, 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => '12级', 'min_exp' => 300001, 'created_at' => $createdAt, 'updated_at' => $createdAt],
        ]);
    }
}
