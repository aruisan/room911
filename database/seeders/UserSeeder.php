<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Asegúrate de importar el modelo de User
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear dos usuarios con el tipo 'admin_room_911'
        User::create([
            'name' => 'Admin User 1',
            'email' => 'admin1@example.com',
            'password' => Hash::make('password123'), // Puedes cambiar la contraseña
            'type' => 'admin_room_911',
        ]);

        User::create([
            'name' => 'Admin User 2',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password123'),
            'type' => 'admin_room_911',
        ]);

        // Crear un usuario con el tipo 'sistemas'
        User::create([
            'name' => 'Sistemas User',
            'email' => 'sistemas@example.com',
            'password' => Hash::make('password123'),
            'type' => 'sistemas',
        ]);
    }
}
