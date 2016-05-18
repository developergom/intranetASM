<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
        	'user_name' => '025407',
        	'user_email' => 'soni@gramedia-majalah.com',
        	'password' => bcrypt('password'),
        	'user_firstname' => 'Soni',
        	'user_lastname' => 'Rahayu',
        	'user_phone' => '081111111111',
        	'user_gender' => '1',
        	'religion_id' => 1,
        	'user_birthdate' => '1990-01-01',
        	'user_avatar' => 'avatar.jpg',
        	'user_status' => 'ACTIVE',
        	'active' => '1',
        	'created_by' => '1',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_by' => '1',
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
