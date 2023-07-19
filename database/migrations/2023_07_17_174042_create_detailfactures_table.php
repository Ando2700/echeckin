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
        Schema::create('detailfactures', function (Blueprint $table) {
            $table->id();
            $table->decimal('montant',12,2);
            $table->foreignId('facture_id')->constrained()->onDelete('cascade');
            $table->foreignId('acte_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailfactures');
    }
};
