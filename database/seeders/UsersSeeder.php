<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
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
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'), // Securely hash the password
                'roleid' => 1,
                'department_id' => null
            ],
            [
                'id' => 3,
                'name' => 'ITDadmin',
                'email' => 'ITDadmin@admin.com',
                'password' => Hash::make('adminpassword'), // Securely hash the password
                'roleid' => 3,
                'department_id' => null
            ]
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}