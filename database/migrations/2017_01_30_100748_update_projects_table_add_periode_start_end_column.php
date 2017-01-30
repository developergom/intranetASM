<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProjectsTableAddPeriodeStartEndColumn extends Migration
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
                DB::statement('ALTER TABLE projects ADD project_periode_start DATE AFTER project_name');
                DB::statement('ALTER TABLE projects ADD project_periode_end DATE AFTER project_periode_start');
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
        //
    }
}
