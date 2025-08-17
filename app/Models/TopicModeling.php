<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicModeling extends Model
{
    use HasFactory;

    protected $table = 'topic_modeling';

    protected $fillable = [
        'topic_id',
        'topic_keywords',
        'doc_count',
        'share',
        'avg_topic_score',
        'avg_sentiment',
        'pos_rate',
        'neg_rate',
        'neu_rate'
    ];

    protected $casts = [
        'topic_id' => 'integer',
        'doc_count' => 'integer',
        'share' => 'float',
        'avg_topic_score' => 'float',
        'avg_sentiment' => 'float',
        'pos_rate' => 'float',
        'neg_rate' => 'float',
        'neu_rate' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get topic sentiment color based on average sentiment
     */
    public function getSentimentColorAttribute()
    {
        if ($this->avg_sentiment >= 0.2) {
            return 'text-green-600 bg-green-100';
        } elseif ($this->avg_sentiment <= -0.2) {
            return 'text-red-600 bg-red-100';
        } else {
            return 'text-yellow-600 bg-yellow-100';
        }
    }

    /**
     * Get topic sentiment label
     */
    public function getSentimentLabelAttribute()
    {
        if ($this->avg_sentiment >= 0.2) {
            return 'Positif';
        } elseif ($this->avg_sentiment <= -0.2) {
            return 'Negatif';
        } else {
            return 'Netral';
        }
    }

    /**
     * Get topic sentiment icon
     */
    public function getSentimentIconAttribute()
    {
        if ($this->avg_sentiment >= 0.2) {
            return '😊';
        } elseif ($this->avg_sentiment <= -0.2) {
            return '😞';
        } else {
            return '😐';
        }
    }

    /**
     * Get share percentage formatted
     */
    public function getSharePercentageAttribute()
    {
        return number_format($this->share * 100, 2) . '%';
    }

    /**
     * Get dominant sentiment based on rates
     */
    public function getDominantSentimentAttribute()
    {
        $rates = [
            'positive' => $this->pos_rate,
            'negative' => $this->neg_rate,
            'neutral' => $this->neu_rate
        ];

        return array_search(max($rates), $rates);
    }

    /**
     * Get topic keywords as array
     */
    public function getKeywordsArrayAttribute()
    {
        return explode(', ', $this->topic_keywords);
    }

    /**
     * Get topic title based on keywords
     */
    public function getTopicTitleAttribute()
    {
        $keywords = $this->keywords_array;
        return 'Topic ' . $this->topic_id . ': ' . implode(', ', array_slice($keywords, 0, 3));
    }

    /**
     * Scope untuk sorting berdasarkan share
     */
    public function scopeByShare($query, $direction = 'desc')
    {
        return $query->orderBy('share', $direction);
    }

    /**
     * Scope untuk sorting berdasarkan sentiment
     */
    public function scopeBySentiment($query, $direction = 'desc')
    {
        return $query->orderBy('avg_sentiment', $direction);
    }

    /**
     * Scope untuk filter topic dengan dokumen minimal
     */
    public function scopeMinDocuments($query, $minDocs = 1)
    {
        return $query->where('doc_count', '>=', $minDocs);
    }
}
