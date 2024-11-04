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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_name');
            $table->string('serial_number')->unique();
            $table->string('asset_no')->unique();
            $table->string('brand');
            $table->string('model');
            $table->string('type');
            $table->string('spec');
            $table->string('model');
            $table->string('domain');
            $table->string('location');
            $table->string('company_id');
            $table->string('department_id');
            $table->string('user_id');
            $table->string('previous_user_id');
            $table->string('paid_by');
            $table->string('condition');
            $table->string('remark');
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
        Schema::dropIfExists('assets');
    }
};
