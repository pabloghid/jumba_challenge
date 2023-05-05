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
            $table->date("RptDt");
            $table->string("TckrSymb");
            $table->string("ISIN");
            $table->string("Asst");
            $table->integer("BalQty");
            $table->float("TradAvrgPric");
            $table->integer("PricFctr");
            $table->float("BalVal");
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
