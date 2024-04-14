<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id('pageid');
            $table->string('header')->unique()->comment('Заголовок статьи');
            $table->longText('contents')->fulltext('article_text_index')->comment('Содержимое статьи');
            $table->float('size')->storedAs('ROUND(LENGTH(contents) / 1024, 2)');
            $table->integer('word_count')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
