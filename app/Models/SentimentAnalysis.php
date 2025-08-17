<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentimentAnalysis extends Model
{
    use HasFactory;

    protected $table = 'sentiment_analysis';

    protected $fillable = [
        'saran',
        'clean_text',
        'sentiment_label',
        'sentiment_score'
    ];

    protected $casts = [
        'sentiment_score' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get sentiment color based on label
     */
    public function getSentimentColorAttribute()
    {
        switch (strtolower($this->sentiment_label)) {
            case 'positif':
            case 'positive':
                return 'text-green-600 bg-green-100';
            case 'negatif':
            case 'negative':
                return 'text-red-600 bg-red-100';
            case 'netral':
            case 'neutral':
                return 'text-yellow-600 bg-yellow-100';
            default:
                return 'text-gray-600 bg-gray-100';
        }
    }

    /**
     * Get sentiment icon based on label
     */
    public function getSentimentIconAttribute()
    {
        switch (strtolower($this->sentiment_label)) {
            case 'positif':
            case 'positive':
                return '😊';
            case 'negatif':
            case 'negative':
                return '😞';
            case 'netral':
            case 'neutral':
                return '😐';
            default:
                return '❓';
        }
    }

    /**
     * Scope untuk filter berdasarkan rentang tanggal
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope untuk filter berdasarkan sentimen
     */
    public function scopeBySentiment($query, $sentiment)
    {
        return $query->where('sentiment_label', $sentiment);
    }
}
