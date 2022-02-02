<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemoCpanelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demo_cpanels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->nullable();
            $table->text('site_url')->nullable();
            $table->text('admin_url')->nullable();
            $table->text('cpanel_url')->nullable();
            $table->text('design_url')->nullable();
            $table->text('programming_brief_url')->nullable();
            $table->string('cpanel_username', 255)->nullable();
            $table->string('cpanel_password', 255)->nullable();
            $table->string('db_username', 255)->nullable();
            $table->string('db_password', 255)->nullable();
            $table->string('db_name', 255)->nullable();
            $table->string('backend_username', 255)->nullable();
            $table->string('backend_password', 255)->nullable();
            $table->string('started_at')->nullable()->default('-');
            $table->string('ended_at')->nullable()->default('-');
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
        Schema::dropIfExists('demo_cpanels');
    }
}
