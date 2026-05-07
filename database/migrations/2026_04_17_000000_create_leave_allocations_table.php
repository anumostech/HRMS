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
        Schema::create('leave_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('leave_type_id')->constrained()->onDelete('cascade');
            $table->integer('allocated_days')->default(0);
            $table->integer('year')->default(date('Y'));
            $table->timestamps();
        });

        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasColumn('employees', 'total_leaves_allocated')) {
                $table->dropColumn('total_leaves_allocated');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_allocations');

        Schema::table('employees', function (Blueprint $table) {
            $table->integer('total_leaves_allocated')->default(0)->after('status');
        });
    }
};
