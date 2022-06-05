<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->string('chat_token');
            $table->boolean('acquire_done')->default(0);
            $table->boolean('owner_done')->default(0);
            $table->unsignedBigInteger('acquire_id');
            $table->foreign("acquire_id")->references("id")->on("users")->onDelete("cascade");
            $table->unsignedBigInteger('owner_id');
            $table->foreign("owner_id")->references("id")->on("users")->onDelete("cascade");
            $table->unsignedBigInteger('machine_id')->nullable();
            $table->foreign("machine_id")->references("id")->on("machines")->onDelete("cascade");
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
        Schema::dropIfExists('conversations');
    }
}
