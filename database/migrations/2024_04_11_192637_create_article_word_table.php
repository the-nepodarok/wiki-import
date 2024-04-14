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
        Schema::create('article_word', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')
                ->references('pageid')
                ->on('articles');
            $table->foreignId('word_id')
                ->references('id')
                ->on('words');
            $table->integer('count');
            $table->unique(['article_id', 'word_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_words');
    }
};
