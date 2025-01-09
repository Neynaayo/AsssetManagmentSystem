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
        Schema::create('history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->nullable();
            $table->unsignedBigInteger('loan_by')->nullable(); // Name or identifier of the person/entity loaning the asset
            $table->date('date_loan')->nullable(); // Date of loan
            $table->date('until_date_loan')->nullable(); // Loan return date
            $table->enum('status', ['Available', 'Disposal', 'Loan'])->nullable(); // Limit status options
            $table->foreignId('disposal_status_id')->nullable()->constrained('disposal_statuses')->onDelete('set null');
            $table->longtext('remark')->nullable(); 
            $table->timestamps(); // Adds created_at and updated_at columns
       
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
            $table->foreign('loan_by')->references('id')->on('staff');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history');
    }
};
