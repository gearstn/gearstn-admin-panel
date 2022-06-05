<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMachineDataMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('machines', function (Blueprint $table) {
            $table->boolean('show_price')->default(0);
            $table->string('manufacturing_place')->nullable();
            $table->unsignedBigInteger('report_id')->nullable();
            $table->foreign("report_id")->references("id")->on("uploads")->onDelete("cascade");

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
            $table->dropForeign(['report_id']);
            $table->dropColumn(['show_price','manufacturing_place','report_id']);
        });
    }
}
