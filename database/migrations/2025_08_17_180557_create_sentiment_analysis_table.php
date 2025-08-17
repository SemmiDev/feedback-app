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
        Schema::create('sentiment_analysis', function (Blueprint $table) {
            $table->id();
            $table->text('saran');
            $table->text('clean_text');
            $table->string('sentiment_label');
            $table->decimal('sentiment_score', 8, 6);
            $table->timestamps();

            $table->index('sentiment_label');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sentiment_analysis');
    }
};
