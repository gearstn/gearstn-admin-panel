<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableForignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign("tax_license_image")->references("id")->on("uploads")->onDelete("cascade");
            $table->foreign("commercial_license_image")->references("id")->on("uploads")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropColumn('position');
        // });
    }
}
