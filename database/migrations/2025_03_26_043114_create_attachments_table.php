<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('attachments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('report_id')->constrained('reports')->onDelete('cascade'); // Foreign key ke tabel reports
        $table->string('file_path');
        $table->string('file_type');
        $table->string('file_name');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
