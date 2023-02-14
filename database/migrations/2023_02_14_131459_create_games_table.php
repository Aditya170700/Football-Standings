<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('home_id');
            $table->unsignedBigInteger('away_id');
            $table->date('date');
            $table->unsignedInteger('home_score');
            $table->unsignedInteger('away_score');
            $table->timestamps();

            $table->foreign('home_id')->references('id')->on('teams')->cascadeOnDelete();
            $table->foreign('away_id')->references('id')->on('teams')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
};
