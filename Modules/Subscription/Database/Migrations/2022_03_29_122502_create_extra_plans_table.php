<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtraPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('number_of_listing');
            $table->integer('photos_of_listing');
            $table->integer('number_of_months');
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->json('machines')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
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
        Schema::dropIfExists('extra_plans');
    }
}
