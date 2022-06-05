<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSparePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spare_parts', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->string('sn')->nullable();
            $table->longText('description');
            $table->string('country');
            $table->string('slug');
            $table->json('images')->nullable();
            $table->boolean('approved')->default(0);
            $table->boolean('featured')->default(0);
            $table->boolean('verified')->default(0);
            $table->string('sku');
            $table->BigInteger('price')->nullable();

            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->unsignedBigInteger('manufacture_id');
            $table->unsignedBigInteger('model_id');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('city_id');
            $table->foreign("category_id")->references("id")->on("categories")->onDelete("cascade");
            $table->foreign("sub_category_id")->references("id")->on("subcategories")->onDelete("cascade");
            $table->foreign("manufacture_id")->references("id")->on("manufactures")->onDelete("cascade");
            $table->foreign("model_id")->references("id")->on("spare_part_models")->onDelete("cascade");
            $table->foreign("seller_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("city_id")->references("id")->on("cities")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spare_parts');
    }
}
