<?php

use Illuminate\Database\Seeder;

class SellPeriodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sell_periods')->insert(array(
        	[
	        	'sell_period_month' => '01',
	        	'sell_period_month_name' => 'January',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'sell_period_month' => '02',
	        	'sell_period_month_name' => 'February',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'sell_period_month' => '03',
	        	'sell_period_month_name' => 'March',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'sell_period_month' => '04',
	        	'sell_period_month_name' => 'April',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'sell_period_month' => '05',
	        	'sell_period_month_name' => 'May',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'sell_period_month' => '06',
	        	'sell_period_month_name' => 'June',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'sell_period_month' => '07',
	        	'sell_period_month_name' => 'July',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'sell_period_month' => '08',
	        	'sell_period_month_name' => 'August',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'sell_period_month' => '09',
	        	'sell_period_month_name' => 'September',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'sell_period_month' => '10',
	        	'sell_period_month_name' => 'October',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'sell_period_month' => '11',
	        	'sell_period_month_name' => 'November',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
	        	'sell_period_month' => '12',
	        	'sell_period_month_name' => 'December',
	        	'active' => '1',
	        	'created_by' => '1',
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_by' => '1',
	        	'updated_at' => date('Y-m-d H:i:s'),
        	])
        );
    }
}
