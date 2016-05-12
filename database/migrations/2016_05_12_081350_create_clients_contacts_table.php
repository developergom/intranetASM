<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('client_contacts', function (Blueprint $table) {
            $table->increments('client_contact_id');
            $table->integer('client_id');
            $table->string('client_name', 100);
            $table->enum('client_gender', ['1','2']); //1 = pria | 2 = wanita
            $table->date('client_birthdate')->nullable();
            $table->integer('religion_id');
            $table->string('client_contact_phone', 15)->unique();
            $table->string('client_contact_email')->unique();
            $table->string('client_contact_position', 100);
            $table->enum('active', ['0', '1'])->default('1');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('client_contacts');
    }
}
