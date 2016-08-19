<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('user_id');
                $table->string('user_name')->unique();
                $table->string('user_email')->unique();
                $table->string('password');
                $table->string('user_firstname');
                $table->string('user_lastname')->nullable();
                $table->string('user_phone', 20)->nullable();
                $table->enum('user_gender', ['1','2']); //1 - Pria | 2 - Wanita
                $table->integer('religion_id');
                $table->date('user_birthdate')->nullable();
                $table->dateTime('user_lastlogin')->nullable();
                $table->ipaddress('user_lastip')->nullable();
                $table->string('user_avatar')->nullable();
                $table->enum('user_status', ['ACTIVE','INACTIVE','BLOCKED','EXPIRED']);
                $table->enum('active', ['0','1'])->default('1');
                $table->integer('created_by');
                $table->integer('updated_by')->nullable();
                $table->rememberToken()->nullable();
                $table->timestamps();
                $table->index(['user_firstname','user_phone','user_birthdate']);
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
        Schema::dropIfExists('users');
    }
}
