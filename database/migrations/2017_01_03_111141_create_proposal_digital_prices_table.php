<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalDigitalPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('proposal_digital_prices')) {
            Schema::create('proposal_digital_prices', function (Blueprint $table) {
                $table->increments('proposal_digital_price_id');
                $table->integer('proposal_id');
                $table->integer('price_type_id');
                $table->integer('media_id');
                $table->integer('advertise_rate_id');
                $table->date('proposal_digital_price_startdate');
                $table->date('proposal_digital_price_enddate');
                $table->date('proposal_digital_price_deadline');
                $table->text('proposal_digital_price_remarks');
                $table->double('proposal_digital_price_gross_rate');
                $table->double('proposal_digital_price_surcharge');
                $table->double('proposal_digital_price_total_gross_rate');
                $table->double('proposal_digital_price_discount');
                $table->double('proposal_digital_price_nett_rate');
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
        Schema::dropIfExists('proposal_digital_prices');
    }
}
