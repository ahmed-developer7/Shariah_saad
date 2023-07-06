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
        Schema::table('employees', function (Blueprint $table) {
            \DB::unprepared('ALTER TABLE `employees` CONVERT TO CHARACTER SET utf8mb4');
            $table->timestamp('updated_at')->nullable()->default(null)->change();
            $table->string('first_name_ar')->after('last_name');
            $table->string('last_name_ar')->after('first_name_ar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            //
        });
    }
};
