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
        Schema::create('open_positions', function (Blueprint $table) {
            $table->id();
            $table->date("date");
            $table->string("tracker_symbol");
            $table->string("ISIN");
            $table->string("asset");
            $table->integer("balance_quantity");
            $table->double("trade_average_price");
            $table->integer("price_factor");
            $table->double("balance_value");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('open_positions');
    }
};
