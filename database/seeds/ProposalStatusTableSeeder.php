<?php

use Illuminate\Database\Seeder;

class ProposalStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('proposal_status')->insert([
            'proposal_status_name' => 'Sold',
        	'active' => '1',
        	'created_by' => '1',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_by' => '1',
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('proposal_status')->insert([
            'proposal_status_name' => 'Not Sold',
            'active' => '1',
            'created_by' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => '1',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('proposal_status')->insert([
            'proposal_status_name' => 'On Process',
            'active' => '1',
            'created_by' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => '1',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }	
}
