<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendasClientContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('agendas_client_contacts')) {
            Schema::create('agendas_client_contacts', function (Blueprint $table) {
                $table->integer('agenda_id');
                $table->integer('client_contact_id');
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
        Schema::dropIfExists('agendas_client_contacts');
    }
}
