<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalPrintPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('proposal_print_prices')) {
            Schema::create('proposal_print_prices', function (Blueprint $table) {
                $table->increments('proposal_print_price_id');
                $table->integer('proposal_id');
                $table->integer('price_type_id');
                $table->integer('media_id');
                $table->integer('media_edition_id');
                $table->integer('advertise_rate_id');
                $table->date('proposal_print_price_startdate');
                $table->date('proposal_print_price_enddate');
                $table->date('proposal_print_price_deadline');
                $table->text('proposal_print_price_remarks');
                $table->double('proposal_print_price_gross_rate');
                $table->double('proposal_print_price_surcharge');
                $table->double('proposal_print_price_total_gross_rate');
                $table->double('proposal_print_price_discount');
                $table->double('proposal_print_price_nett_rate');
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
        Schema::dropIfExists('proposal_print_prices');
    }
}
