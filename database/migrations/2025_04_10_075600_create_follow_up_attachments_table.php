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
        Schema::create('follow_up_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('follow_up_id')
                ->constrained('follow_ups')
                ->onDelete('cascade');
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
        Schema::dropIfExists('follow_up_attachments');
    }
};
