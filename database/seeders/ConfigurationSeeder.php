<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Config::create([
            'key' => 'company_name',
            'value' => 'Aplicación Web',
        ]);
        Config::create([
            'key' => 'company_cif',
            'value' => 'X-XX.XXX.XXX',
        ]);
        Config::create([
            'key' => 'company_address',
            'value' => 'C/ TEST',
        ]);
        Config::create([
            'key' => 'company_zip_code',
            'value' => '99999',
        ]);
        Config::create([
            'key' => 'company_town',
            'value' => 'TEST',
        ]);
        Config::create([
            'key' => 'company_province',
            'value' => 'TEST',
        ]);
        Config::create([
            'key' => 'company_phone',
            'value' => '999999999',
        ]);
        Config::create([
            'key' => 'company_email',
            'value' => 'mshupik@logic10.net',
        ]);
        Config::create([
            'key' => 'theme_color',
            'value' => '#5a5c69',
        ]);
        Config::create([
            'key' => 'company_app',
            'value' => 'XXX_XXX_XXX',
        ]);
        Config::create([
            'key' => 'max_user_number',
            'value' => '8',
        ]);
    }
}
