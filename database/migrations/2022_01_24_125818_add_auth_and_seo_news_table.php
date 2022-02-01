<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthAndSeoNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->integer('mins_read')->nullable();
            $table->string('author_en', 255)->nullable();
            $table->string('author_ar', 255)->nullable();
            $table->string('seo_title_en', 255)->nullable();
            $table->string('seo_title_ar', 255)->nullable();
            $table->string('seo_description_en', 255)->nullable();
            $table->string('seo_description_ar', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *  
     * @return void
     */
    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['mins_read','author_en','author_ar','seo_title_en','seo_title_ar' , 'seo_description_en','seo_description_ar']);
        });
    }
}
