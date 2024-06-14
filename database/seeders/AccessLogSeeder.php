<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AccessLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccessLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $num = rand(250,300);
        AccessLog::factory()->count($num)->create();
    }
}
