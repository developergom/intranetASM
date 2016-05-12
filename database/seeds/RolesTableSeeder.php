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
        //
        DB::table('roles')->insert([
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
