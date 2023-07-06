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
        Schema::create('observations', function (Blueprint $table) {
            $table->id();
            $table->year('year')->nullable();
            $table->string('function')->nullable();
            $table->string('description')->nullable();
            $table->string('observation_details')->nullable();
            $table->string('risk')->nullable();
            $table->string('recommendation')->nullable();
            $table->string('management_response')->nullable();
            $table->date('date_of_audit')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('company_id');
            $table->integer('project_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('project_id')->references('project_id')->on('projects')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('observations');
    }
};
