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
        Schema::create('type_classification', function (Blueprint $table) {
            $table->integer('type_id');
            $table->integer('classification_id');
            $table->foreign('type_id')->references('id')->on('kind_of_products')->onDelete('cascade');
            $table->foreign('classification_id')->references('id')->on('product_classification')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classification_type');
    }
};
