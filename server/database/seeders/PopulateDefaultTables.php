<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\User_Roles;
use App\Models\Status_Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PopulateDefaultTables extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User_Roles::create([
            'role' => 'User',
        ]);
        User_Roles::create([
            'role' => 'Admin',
        ]);

        Status_Role::create([
            'status' => 'Open',
        ]);
        Status_Role::create([
            'status' => 'Accepted',
        ]);
        Status_Role::create([
            'status' => 'Refused',
        ]);
        Categories::create([
            'name' => 'Home',
        ]);
        Categories::create([
            'name' => 'Sports'
        ]);
    }
}
