<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke tabel users
            $table->foreignId('category_id')->constrained('complaint_categories')->onDelete('restrict'); // Relasi ke tabel complaint_categories
            $table->foreignId('status_id')->constrained('complaint_statuses')->onDelete('restrict'); // Relasi ke tabel complaint_statuses
            $table->string('title');
            $table->text('description');
            $table->string('file_path')->nullable(); // Path untuk file bukti pengaduan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
