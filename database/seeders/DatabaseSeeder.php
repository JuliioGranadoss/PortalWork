<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'manager']);
        Role::create(['name' => 'worker']);

        
        $user = User::create([
            'name' => 'Julio Granados',
            'email' => 'juliogd2004@gmail.com',
            'password' => Hash::make('9ev4b65A!XHC'),
        ]);


        $user->assignRole('admin');
    }
}
