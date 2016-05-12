<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('client_id');
            $table->integer('client_type_id');
            $table->string('client_name');
            $table->string('client_formal_name');
            $table->text('client_mail_address');
            $table->string('client_mail_postcode', 10);
            $table->string('client_npwp', 25);
            $table->text('client_npwp_address');
            $table->string('client_npwp_postcode', 10);
            $table->text('client_invoice_address');
            $table->string('client_invoice_postcode', 10);
            $table->string('client_phone', 15);
            $table->string('client_fax', 15);
            $table->string('client_email')->unique();
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
        Schema::dropIfExists('clients');
    }
}
