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
        Schema::create('specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subcategory_id')->constrained('sub_categories')->onDelete('cascade');
            $table->string('title');
            $table->text('content'); // المحتوى الكامل
            $table->string('file_path')->nullable(); // رابط الملف الأصلي إذا أردتِ رفعه
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specifications');
    }
};
