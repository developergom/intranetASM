<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('summaries')) {
            Schema::create('summaries', function (Blueprint $table) {
                $table->increments('summary_id');
                $table->integer('proposal_id');
                $table->string('summary_order_no', 50);
                $table->date('summary_sent_date');
                $table->double('summary_total_gross');
                $table->double('summary_total_disc');
                $table->double('summary_total_nett');
                $table->double('summary_total_po');
                $table->double('summary_total_internal_omzet');
                $table->enum('top_type', ['bulk','termin','insertion']);
                $table->integer('top_count');
                $table->integer('revision_no');
                $table->integer('current_user');
                $table->integer('flow_no');
                $table->integer('pic');
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
        Schema::dropIfExists('summaries');
    }
}
