<?php

use Illuminate\Database\Seeder;

class ImplementationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('implementations')->insert(array(
        	[
	        	'implementation_month' => '01',
	        	'implementation_month_name' => 'January',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'implementation_month' => '02',
	        	'implementation_month_name' => 'February',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'implementation_month' => '03',
	        	'implementation_month_name' => 'March',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'implementation_month' => '04',
	        	'implementation_month_name' => 'April',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'implementation_month' => '05',
	        	'implementation_month_name' => 'May',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'implementation_month' => '06',
	        	'implementation_month_name' => 'June',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'implementation_month' => '07',
	        	'implementation_month_name' => 'July',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'implementation_month' => '08',
	        	'implementation_month_name' => 'August',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'implementation_month' => '09',
	        	'implementation_month_name' => 'September',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'implementation_month' => '10',
	        	'implementation_month_name' => 'October',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'implementation_month' => '11',
	        	'implementation_month_name' => 'November',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'implementation_month' => '12',
	        	'implementation_month_name' => 'December',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	])
        );
    }
}
