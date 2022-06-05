<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHourmeterSerialPhotosToMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('machines', function (Blueprint $table) {
            $table->unsignedBigInteger('serial_photo_id')->nullable();
            $table->unsignedBigInteger('hourmeter_photo_id')->nullable();
            $table->foreign("serial_photo_id")->references("id")->on("uploads")->onDelete("cascade");
            $table->foreign("hourmeter_photo_id")->references("id")->on("uploads")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('machines', function (Blueprint $table) {
            $table->dropForeign(['serial_photo_id', 'hourmeter_photo_id']);
            $table->dropColumn(['serial_photo_id', 'hourmeter_photo_id']);
        });
    }
}
