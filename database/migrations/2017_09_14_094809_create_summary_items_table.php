<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSummaryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('summary_items')) {
            Schema::create('summary_items', function (Blueprint $table) {
                $table->increments('summary_item_id');
                $table->integer('rate_id');
                $table->enum('summary_item_type', ['media_cost', 'cost_pro']);
                $table->date('summary_item_period_start');
                $table->date('summary_item_period_end');
                $table->integer('omzet_type_id');
                $table->integer('summary_item_insertion');
                $table->double('summary_item_gross');
                $table->double('summary_item_disc');
                $table->double('summary_item_nett');
                $table->double('summary_item_po');
                $table->double('summary_item_internal_omzet');
                $table->text('summary_item_remarks');
                $table->integer('revision_no');
                $table->integer('po_id');
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
        Schema::dropIfExists('summary_items');
    }
}
