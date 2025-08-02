<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon; // Add this import

class Feedback extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'feedbacks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'rating',
        'comment',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Get rating as stars
     */
    public function getStarsAttribute(): string
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    /**
     * Get rating color class
     */
    public function getRatingColorAttribute(): string
    {
        return match($this->rating) {
            1, 2 => 'text-red-500',
            3 => 'text-yellow-500',
            4, 5 => 'text-green-500',
            default => 'text-gray-500'
        };
    }

    /**
     * Get created_at in WIB timezone
     */
    public function getCreatedAtWibAttribute(): Carbon
    {
        // Ensure return type is Illuminate\Support\Carbon
        return Carbon::instance($this->created_at->setTimezone('Asia/Jakarta'));
    }

    /**
     * Get updated_at in WIB timezone
     */
    public function getUpdatedAtWibAttribute(): Carbon
    {
        // Ensure return type is Illuminate\Support\Carbon
        return Carbon::instance($this->updated_at->setTimezone('Asia/Jakarta'));
    }

    /**
     * Get formatted created_at in WIB
     */
    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at_wib->format('d M Y, H:i') . ' WIB';
    }

    /**
     * Get formatted created_at for humans in WIB
     */
    public function getCreatedAtForHumansAttribute(): string
    {
        return $this->created_at_wib->diffForHumans();
    }

    /**
     * Get formatted date only in WIB
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->created_at_wib->format('d M Y');
    }

    /**
     * Get formatted time only in WIB
     */
    public function getFormattedTimeAttribute(): string
    {
        return $this->created_at_wib->format('H:i') . ' WIB';
    }

    /**
     * Get formatted datetime for display in WIB
     */
    public function getDisplayDatetimeAttribute(): string
    {
        return $this->created_at_wib->format('F j, Y \a\t g:i A') . ' WIB';
    }

    /**
     * Scope for filtering by rating
     */
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Scope for recent feedbacks
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
