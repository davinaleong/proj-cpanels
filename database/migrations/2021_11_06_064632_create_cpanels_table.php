<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpanelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpanels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_type_id')->constrained('project_types')->nullable();
            $table->foreignId('image_id')->constrained('images')->nullable();
            $table->text('site_url')->nullable();
            $table->text('admin_url')->nullable();
            $table->text('cpanel_url')->nullable();
            $table->string('cpanel_username', 255)->nullable();
            $table->string('cpanel_password', 255)->nullable();
            $table->string('backend_username', 255)->nullable();
            $table->string('backend_password', 255)->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('cpanels');
    }
}
