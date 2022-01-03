<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveSubCategoryIdInManufacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manufactures', function (Blueprint $table) {
            $table->dropForeign(['sub_category_id']);
            $table->dropColumn(['sub_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manufactures', function (Blueprint $table) {
            $table->unsignedBigInteger('sub_category_id');
            $table->foreign("sub_category_id")->references("id")->on("subcategories")->onDelete("cascade");
        });
    }
}
