<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents_types', function (Blueprint $table) {
            $table->unsignedBigInteger('document_id');
            $table->integer('type_id');
            $table->foreign('document_id')->references('id')->on('product_documents')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('kind_of_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents_types');
    }
};
