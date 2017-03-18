<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $users = [
            [
                'name' => 'moderator',
                'username' => 'moderator',
                'email' => 'moderator@test.com',
                'password' => Hash::make( 'password' ),
                'type' => 1
            ],
            [
                'name' => 'hr manager',
                'username' => 'hrmanager',
                'email' => 'hrmanager@test.com',
                'password' => Hash::make( 'password' ),
                'type' => 0
            ]
        ];

        $db = DB::table('users')->insert($users);
    }
}
