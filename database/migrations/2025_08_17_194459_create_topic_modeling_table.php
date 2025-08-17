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
        Schema::create('topic_modeling', function (Blueprint $table) {
            $table->id();
            $table->integer('topic_id');
            $table->text('topic_keywords');
            $table->integer('doc_count');
            $table->decimal('share', 8, 6);
            $table->decimal('avg_topic_score', 8, 6);
            $table->decimal('avg_sentiment', 8, 6);
            $table->decimal('pos_rate', 8, 6);
            $table->decimal('neg_rate', 8, 6);
            $table->decimal('neu_rate', 8, 6);
            $table->timestamps();

            $table->index('topic_id');
            $table->index('share');
            $table->index('avg_sentiment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topic_modeling');
    }
};
