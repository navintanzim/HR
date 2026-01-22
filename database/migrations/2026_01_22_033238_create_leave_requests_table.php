<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->string('leave_type');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('total_days');
            $table->longText('reason');
            $table->string('status');
            $table->longText('admin_note')->nullable();
            $table->dateTime('submitted_at');
            $table->dateTime('decided_at')->nullable();
            $table->integer('decided_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
