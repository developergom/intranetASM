<?php

use Illuminate\Database\Seeder;

class ActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('actions')->insert([
            'action_name' => 'Create',
        	'action_alias' => 'C',
            'action_desc' => 'Action Control to Create New Item',
        	'active' => '1',
        	'created_by' => '1',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_by' => '1',
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('actions')->insert([
            'action_name' => 'Read',
            'action_alias' => 'R',
            'action_desc' => 'Action Control to Read/View Item',
            'active' => '1',
            'created_by' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => '1',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);             

        DB::table('actions')->insert([
            'action_name' => 'Update',
            'action_alias' => 'U',
            'action_desc' => 'Action Control to Update Item',
            'active' => '1',
            'created_by' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => '1',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);        

        DB::table('actions')->insert([
            'action_name' => 'Delete',
            'action_alias' => 'D',
            'action_desc' => 'Action Control to Delete Item',
            'active' => '1',
            'created_by' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => '1',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('actions')->insert([
            'action_name' => 'Download',
            'action_alias' => 'DL',
            'action_desc' => 'Action Control to Download Item',
            'active' => '1',
            'created_by' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => '1',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('actions')->insert([
            'action_name' => 'Upload',
            'action_alias' => 'UL',
            'action_desc' => 'Action Control to Upload Item',
            'active' => '1',
            'created_by' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => '1',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
