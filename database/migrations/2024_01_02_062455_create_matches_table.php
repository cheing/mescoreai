<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id');
            $table->dateTime('start_time');
            $table->boolean('status');
            $table->unsignedBigInteger('team_a_id');
            $table->unsignedBigInteger('team_b_id');
            $table->string('first_odd')->nullable();
            $table->string('x_odd')->nullable();
            $table->string('second_odd')->nullable();
            $table->string('tip')->nullable();
            $table->string('tip_odd')->nullable();
            $table->string('handicap')->nullable();
            $table->string('handicap_odd')->nullable();
            $table->string('o_u')->nullable();
            $table->string('o_u_odd')->nullable();
            $table->string('correct_score')->nullable();
            $table->string('correct_score_odd')->nullable();
            $table->string('best_tip')->nullable();
            $table->string('best_tip_odd')->nullable();
            $table->timestamps();
            $table->foreign('tournament_id')->references('id')->on('tournaments');
            $table->foreign('team_a_id')->references('id')->on('teams');
            $table->foreign('team_b_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
};
