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
        Schema::table('open_positions', function (Blueprint $table) {
            $table->dropColumn('ISIN');
            $table->dropColumn('asset');
            $table->dropColumn('tracker_symbol');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('open_positions', function (Blueprint $table) {
            $table->string('ISIN');
            $table->string('asset');
            $table->string('tracker_symbol');
        });
    }
};
