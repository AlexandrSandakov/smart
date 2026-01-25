<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Role::where('name', 'manager')->doesntExist()) {
            Role::create(['name' => 'manager', 'guard_name' => 'web']);
        }
    }
}
