<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Master;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('masters')->truncate();

        Master::create([
            'name' => 'Master',
            'email' => 'davidjimmydegreatman@gmail.com',
            'password' => Hash::make('davidjimmydegreatman@gmail.com'),
        ]);
    }
}
