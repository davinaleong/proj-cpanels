<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorColumnsToProjectTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_types', function (Blueprint $table) {
            $table->string('text_color', 7)->default('#000000')->after('name');
            $table->string('bg_color', 7)->default('#ffffff')->after('text_color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_types', function (Blueprint $table) {
            $table->dropIfExists('text_color');
            $table->dropIfExists('bg_color');
        });
    }
}
