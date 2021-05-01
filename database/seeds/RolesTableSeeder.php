<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Superadmin',
                'slug' => 'superadmin'
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
            ],
            [
                'name' => 'User',
                'slug' => 'user',
            ]
        ];
        foreach ($roles as  $role) {
            DB::table('roles')->insert($role);
        }
        
    }
}
