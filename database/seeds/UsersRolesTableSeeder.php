<?php

use Illuminate\Database\Seeder;

class UsersRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users_roles')->insert([
        	'user_id' => '1',
        	'role_id' => '1',
        	'created_by' => '1',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_by' => '1',
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
