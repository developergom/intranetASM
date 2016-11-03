<?php

use Illuminate\Database\Seeder;

class PriceTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('price_types')->insert([
            'price_type_name' => 'Print Price',
            'price_type_desc' => 'Print Price',
        	'active' => '1',
        	'created_by' => '1',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_by' => '1',
        	'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('price_types')->insert([
            'price_type_name' => 'Digital Price',
            'price_type_desc' => 'Digital Price',
            'active' => '1',
            'created_by' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => '1',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('price_types')->insert([
            'price_type_name' => 'Event Price',
            'price_type_desc' => 'Event Price',
            'active' => '1',
            'created_by' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => '1',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('price_types')->insert([
            'price_type_name' => 'Creative Price',
            'price_type_desc' => 'Creative Price',
            'active' => '1',
            'created_by' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => '1',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('price_types')->insert([
            'price_type_name' => 'Other Price',
            'price_type_desc' => 'Other Price',
            'active' => '1',
            'created_by' => '1',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => '1',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }	
}
