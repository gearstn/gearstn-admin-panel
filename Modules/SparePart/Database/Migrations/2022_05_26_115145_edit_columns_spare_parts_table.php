<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditColumnsSparePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spare_parts', function (Blueprint $table) {
            $table->dropForeign(['model_id']);
            $table->dropColumn(['year','sn','model_id']);
            $table->boolean('is_original')->after('price');
            $table->string('condition')->after('is_original');
            $table->unsignedBigInteger('manufacture_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spare_parts', function (Blueprint $table) {
            $table->unsignedBigInteger('model_id');
            $table->foreign("model_id")->references("id")->on("spare_part_models")->onDelete("cascade");
            $table->integer('year');
            $table->string('sn')->nullable();
            $table->dropColumn(['is_original','condition']);
            $table->unsignedBigInteger('manufacture_id')->change();
        });
    }
}
