<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailToLiveCpanels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_cpanels', function (Blueprint $table) {
            $table->string('noreply_email', 255)->nullable()->after('backend_password');
            $table->string('noreply_password', 255)->nullable()->after('backend_password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_cpanels', function (Blueprint $table) {
            $table->dropColumn('noreply_email');
            $table->dropColumn('noreply_password');
        });
    }
}
