<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\OpenPositions;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        OpenPositions::truncate();

        Schema::table('open_positions', function (Blueprint $table) {
            $table->unsignedBigInteger('asset_id');

            $table->foreign('asset_id')->references('id')->on('assets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('open_positions', function (Blueprint $table) {
            $table->dropForeign(['asset_id']);
            $table->dropColumn('asset_id');
        });
    }
};
