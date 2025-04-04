<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedTwittersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_twitters', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('reply_to_id')->nullable();
            $table->integer('supporter_id')->unsigned()->nullable();
            $table->string('profile_id')->nullable();
            $table->string('message');
            $table->enum('type', ['tweet', 'direct message']);
            $table->boolean('is_active')->default(true);
            $table->timestampTz('created_time')->nullable();
            $table->softDeletes(); // spam purpose
            $table->timestamps();

            $table->foreign('supporter_id')->references('id')->on('sys_users');
            $table->foreign('profile_id')->references('id')->on('feed_facebook_profiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('feed_twitters');
    }
}
