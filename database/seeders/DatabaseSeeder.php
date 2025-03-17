<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin',
                'role' => 'admin',
                'email' => 'joko@gmail.com',
            ],
            [
                'name' => 'admin1',
                'role' => 'admin',
                'email' => 'admin@gmail.com'
            ],
        ];
        foreach ($users as $user) {
            $user['password'] = Hash::make('123456');
            DB::table('users')->insert($user);
        }
    }
    
}
