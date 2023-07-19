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
        Schema::table('actes', function (Blueprint $table) {
            $table->string('reference', 3)->nullable();
        });
        Schema::table('depenses', function (Blueprint $table) {
            $table->string('reference', 3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actes', function (Blueprint $table) {
            //
        });
        Schema::table('depenses', function (Blueprint $table) {
            //
        });
    }
};
