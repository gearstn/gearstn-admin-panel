<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyAccountManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_manager_requests', function (Blueprint $table) {
            $table->dropForeign(['assigned_to_id']);
            $table->dropColumn(['first_name', 'last_name', 'email', 'company_name', 'reason', 'assigned_to_id']);
            $table->boolean('read')->default(0)->after('user_id');
            $table->boolean('done')->default(0)->after('user_id');
            $table->longText('message')->nullable()->after('user_id');
            $table->string('request_type')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('account_manager_requests', function (Blueprint $table) {
            $table->dropColumn(['request_type', 'message', 'read', 'done']);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('company_name')->nullable();
            $table->string('reason')->nullable();
            $table->unsignedBigInteger('assigned_to_id')->nullable();
            $table->foreign("assigned_to_id")->references("id")->on("users")->onDelete("cascade");
        });
    }
}
