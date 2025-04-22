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
        Schema::create('reported_parties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->onDelete('cascade');
            $table->string('reported_name');
            $table->string('reported_unit')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reported_parties');
    }
};
