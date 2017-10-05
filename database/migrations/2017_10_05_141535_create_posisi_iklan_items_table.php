<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosisiIklanItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('posisi_iklan_items')) {
            Schema::create('posisi_iklan_items', function (Blueprint $table) {
                $table->increments('posisi_iklan_item_id');
                $table->integer('summary_item_id');
                $table->integer('client_id');
                $table->string('posisi_iklan_item_name');
                $table->integer('industry_id');
                $table->integer('sales_id');
                $table->string('posisi_iklan_item_page_no');
                $table->string('posisi_iklan_item_canal');
                $table->string('posisi_iklan_item_order_digital');
                $table->string('posisi_iklan_item_materi');
                $table->string('posisi_iklan_item_status_materi');
                $table->string('posisi_iklan_item_capture_materi');
                $table->string('posisi_iklan_item_sales_order');
                $table->double('posisi_iklan_item_nett');
                $table->double('posisi_iklan_item_ppn');
                $table->double('posisi_iklan_item_total');
                $table->integer('revision_no');
                $table->enum('active', ['0', '1'])->default('1');
                $table->integer('created_by');
                $table->integer('updated_by');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posisi_iklan_items');
    }
}
