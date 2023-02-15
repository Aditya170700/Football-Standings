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
        Schema::create('standings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->unsignedInteger('ma')->default(0);
            $table->unsignedInteger('me')->default(0);
            $table->unsignedInteger('s')->default(0);
            $table->unsignedInteger('k')->default(0);
            $table->unsignedInteger('gm')->default(0);
            $table->unsignedInteger('gk')->default(0);
            $table->integer('sg')->default(0);
            $table->unsignedInteger('point')->default(0);
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('standings');
    }
};
