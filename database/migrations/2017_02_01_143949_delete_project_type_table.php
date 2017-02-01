<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteProjectTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('projects')) {
            Schema::table('projects', function($table) {
                DB::statement('ALTER TABLE projects DROP COLUMN project_type_id');
            });
        }

        if (Schema::hasTable('project_types')) {
            DB::statement('DROP TABLE project_types');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
