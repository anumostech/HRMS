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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('trade_license_name')->nullable();
            $table->string('trade_license_number')->nullable();
            $table->date('trade_license_expiry')->nullable();
            $table->string('trade_license_attachment')->nullable();
            $table->string('establishment_card_number')->nullable();
            $table->date('establishment_card_expiry')->nullable();
            $table->string('establishment_card_attachment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'trade_license_name',
                'trade_license_number',
                'trade_license_expiry',
                'trade_license_attachment',
                'establishment_card_number',
                'establishment_card_expiry',
                'establishment_card_attachment',
            ]);
        });
    }
};
