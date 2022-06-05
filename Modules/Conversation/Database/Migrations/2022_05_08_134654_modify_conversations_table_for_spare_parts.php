<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyConversationsTableForSpareParts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->string('model_type')->after('owner_id')->nullable();
            $table->dropForeign(['machine_id']);
            $table->renameColumn('machine_id','model_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->renameColumn('model_id','machine_id');
            $table->foreign("machine_id")->references("id")->on("machines")->onDelete("cascade");
            $table->dropColumn(['model_type']);
        });

    }
}
