<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            ['name' => 'Finanzas'],
            ['name' => 'Administrativo'],
            ['name' => 'Talento Humano'],
            ['name' => 'Sistemas'],
            ['name' => 'Contabilidad'],
            ['name' => 'Marketing'],
            ['name' => 'Planeación']
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
