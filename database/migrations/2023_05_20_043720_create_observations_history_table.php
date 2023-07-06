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
        Schema::create('observations_history', function (Blueprint $table) {
            $table->id();
            $table->string('field');
            $table->string('original_value')->nullable();
            $table->string('changed_value')->nullable();
            $table->unsignedBigInteger('observation_id');
            $table->foreign('observation_id')->references('id')->on('observations')->onDelete('cascade');
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
        Schema::dropIfExists('observations_history');
    }
};
