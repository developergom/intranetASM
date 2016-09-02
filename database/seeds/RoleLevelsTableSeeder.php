<?php

use Illuminate\Database\Seeder;

class RoleLevelsTableSeeder extends Seeder
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

        DB::table('role_levels')->insert([
            'role_level_name' => 'Level 1',
            'role_level_desc' => 'Staff',
        	'active' => '1',
        	'created_by' => '1',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_by' => '1',
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('role_levels')->insert([
            'role_level_name' => 'Level 2',
            'role_level_desc' => 'Superintendent',
            'active' => '1',
            'created_by' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => '1',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('role_levels')->insert([
            'role_level_name' => 'Level 3',
            'role_level_desc' => 'Manager',
            'active' => '1',
            'created_by' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => '1',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('role_levels')->insert([
            'role_level_name' => 'Level 4',
            'role_level_desc' => 'Division Head',
            'active' => '1',
            'created_by' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => '1',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('role_levels')->insert([
            'role_level_name' => 'Level 5',
            'role_level_desc' => 'General Manager',
            'active' => '1',
            'created_by' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => '1',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('role_levels')->insert([
            'role_level_name' => 'Level 6',
            'role_level_desc' => 'Administrator',
            'active' => '1',
            'created_by' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => '1',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('role_levels')->insert([
            'role_level_name' => 'Level 7',
            'role_level_desc' => 'Super Administrator',
            'active' => '1',
            'created_by' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => '1',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }	
}
