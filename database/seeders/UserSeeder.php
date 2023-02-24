<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin admin', 
            'email' => 'admin@gmail.com', 
            'password' => 1234
        ])
        ->assignRole('Administrador');

        User::create([
            'name' => 'Editor Editor', 
            'email' => 'editor@gmail.com', 
            'password' => 1234
        ])
        ->assignRole('Editor');
    
        User::create([
            'name' => 'Lector lector', 
            'email' => 'lector@gmail.com', 
            'password' => 1234
        ])
        ->assignRole('Lector');
        
    }
}
