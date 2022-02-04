<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveCpanelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_cpanels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->nullable();
            $table->text('site_url')->nullable();
            $table->text('admin_url')->nullable();
            $table->text('cpanel_url')->nullable();
            $table->string('cpanel_username', 255)->nullable();
            $table->string('cpanel_password', 255)->nullable();
            $table->string('db_username', 255)->nullable();
            $table->string('db_password', 255)->nullable();
            $table->string('db_name', 255)->nullable();
            $table->string('admin_panel', 255)->nullable();
            $table->string('backend_username', 255)->nullable();
            $table->string('backend_password', 255)->nullable();
            $table->string('lived_at')->nullable()->default('-');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('live_cpanels');
    }
}
