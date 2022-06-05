<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBodytextArInNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->renameColumn('bodytext', 'bodytext_en');
            $table->renameColumn('image_url', 'image_id');
            $table->longText('bodytext_ar');
            $table->string('slug')->nullable()->change();

            // $table->unsignedBigInteger('image_id')->nullable()->change();
            // $table->foreign("image_id")->references("id")->on("uploads")->onDelete("cascade");
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
            $table->renameColumn('image_id', 'image_url');
            $table->renameColumn('bodytext_en', 'bodytext');
            $table->dropColumn('bodytext_ar');
        });
    }
}
