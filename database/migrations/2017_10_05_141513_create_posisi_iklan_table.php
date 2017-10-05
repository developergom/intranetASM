<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosisiIklanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('posisi_iklan')) {
            Schema::create('posisi_iklan', function (Blueprint $table) {
                $table->increments('posisi_iklan_id');
                $table->string('posisi_iklan_code');
                $table->integer('media_id');
                $table->char('posisi_iklan_month', 2);
                $table->char('posisi_iklan_year', 4);
                $table->date('posisi_iklan_edition');
                $table->enum('posisi_iklan_type', ['print', 'digital']);
                $table->text('posisi_iklan_notes');
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
        Schema::dropIfExists('posisi_iklan');
    }
}
