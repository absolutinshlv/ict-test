<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->references('id')
                ->on('categories')->onDelete('cascade');
            $table->foreignId('blog_id')->references('id')
                ->on('blogs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_category');
    }
};
