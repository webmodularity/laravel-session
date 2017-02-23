<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('user_agent_id')->nullable();
            $table->text('payload');
            $table->integer('last_activity');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('user_agent_id')->references('id')->on('log_user_agents')->onUpdate('cascade')->onDelete('set null');
        });

        DB::statement('ALTER TABLE `sessions` ADD `ip_address` VARBINARY(16) AFTER `user_id`');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
