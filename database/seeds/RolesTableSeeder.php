<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**LEVEL ROLE
        * Level 1 -> Staff
        * Level 2 -> Superintendent
        * Level 3 -> Manager
        * Level 4 -> Division Head
        * Level 5 -> General Manager
        * Level 6 -> Administrator
        * Level 7 -> Super Administrator
        **/
        DB::table('roles')->insert([
            'role_level_id' => '7',
        	'role_name' => 'Super Administrator',
        	'role_desc' => 'Tipe user super administrator',
        	'active' => '1',
        	'created_by' => '1',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_by' => '1',
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('roles')->insert([
            'role_level_id' => '6',
            'role_name' => 'Administrator',
            'role_desc' => 'Tipe user administrator',
            'active' => '1',
            'created_by' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => '1',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }	
}
