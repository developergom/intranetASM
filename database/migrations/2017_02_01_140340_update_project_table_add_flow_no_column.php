<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProjectTableAddFlowNoColumn extends Migration
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
                DB::statement('ALTER TABLE projects ADD project_type_id INTEGER AFTER project_id');
                DB::statement('ALTER TABLE projects ADD project_ready_date DATETIME AFTER client_id');
                DB::statement('ALTER TABLE projects ADD project_delivery_date DATETIME AFTER project_ready_date');
                DB::statement('ALTER TABLE projects ADD flow_no INTEGER AFTER project_delivery_date');
                DB::statement('ALTER TABLE projects ADD revision_no INTEGER AFTER flow_no');
                DB::statement('ALTER TABLE projects ADD pic INTEGER AFTER revision_no');
                //DB::statement('ALTER TABLE projects ADD current_user INTEGER AFTER pic');
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
