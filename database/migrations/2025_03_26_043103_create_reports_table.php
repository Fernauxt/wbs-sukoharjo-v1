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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('informant_id')->constrained('informants')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('report_categories')->onDelete('restrict');
            $table->string('reported_name');
            $table->string('reported_unit');
            $table->string('subject');
            $table->text('description');
            $table->string('location');
            $table->string('incident_time');
            $table->json('attachments')->nullable();
            $table->foreignId('status_id')->constrained('statuses')->onDelete('restrict');
            $table->timestamp('reported_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
