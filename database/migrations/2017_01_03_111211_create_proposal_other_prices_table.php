<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalOtherPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('proposal_other_prices')) {
            Schema::create('proposal_other_prices', function (Blueprint $table) {
                $table->increments('proposal_other_price_id');
                $table->integer('proposal_id');
                $table->integer('price_type_id');
                $table->integer('media_id');
                $table->text('proposal_other_price_remarks');
                $table->double('proposal_other_price_gross_rate');
                $table->double('proposal_other_price_surcharge');
                $table->double('proposal_other_price_total_gross_rate');
                $table->double('proposal_other_price_discount');
                $table->double('proposal_other_price_nett_rate');
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
        Schema::dropIfExists('proposal_other_prices');
    }
}
