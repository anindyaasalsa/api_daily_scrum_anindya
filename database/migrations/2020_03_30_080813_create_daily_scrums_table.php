<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyScrumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_scrums', function (Blueprint $table) {
            $table->id();
            $table->integer('id_users');
            $table->enum('team', array('DDS','BEON','node1','node2','react1','react2','laravel,','laravel_vue','android'))->default('DDS');
            $table->string('activity_yesterday');
            $table->string('activity_today');
            $table->string('problem_yesterday');
            $table->string('solution');
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
        Schema::dropIfExists('daily_scrums');
    }
}
