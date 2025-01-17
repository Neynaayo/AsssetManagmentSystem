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
            $table->string('serial_number')->nullable();
            $table->string('asset_no')->nullable();
            $table->string('location')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('type')->nullable();
            $table->string('spec')->nullable();
            $table->string('domain')->nullable();
            $table->foreignId('company_id')->nullable()->constrained('company')->onDelete('set null'); 
            $table->foreignId('department_id')->nullable()->constrained('department')->onDelete('set null'); 
            $table->foreignId('user_id')->nullable()->constrained('staff')->onDelete('set null'); // Set null if staff is deleted
            $table->foreignId('previous_user_id')->nullable()->constrained('staff')->onDelete('set null'); // Set null if staff is deleted
            $table->string('paid_by')->nullable();
            $table->string('conditions')->nullable();
            $table->text('remark')->nullable();
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
