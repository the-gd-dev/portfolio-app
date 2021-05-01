<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Ghanshyam Dhiman',
                'role_id' => 1,
                'username' => 'superadmin',
                'email' => 'superadmin@urportfolio.in',
                'password' => Hash::make('123456'),  //Me4Ak8Ha5G
            ],
            [
                'name' => 'Admin User',
                'role_id' => 2,
                'username' => 'admin',
                'email' => 'admin@urportfolio.in',
                'password' => Hash::make('123456'),  //Me4Ak8Ha5G
            ],
            [
                'name' => 'User',
                'role_id' => 3,
                'username' => 'user',
                'email' => 'user@urportfolio.in',
                'password' => Hash::make('123456'),  //Me4Ak8Ha5G
            ]
        ];
        foreach ($users as  $user) {
            DB::table('users')->insert($user);
        }
    }
}
