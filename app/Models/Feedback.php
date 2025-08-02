<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
        'nama_penceramah',
        'nama_masjid',
        'imapp_id_penceramah',
        'imapp_id_masjid',
        'relevansi_rating',
        'kejelasan_rating',
        'pemahaman_jamaah_rating',
        'kesesuaian_waktu_rating',
        'interaksi_jamaah_rating',
        'saran',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'relevansi_rating' => 'integer',
        'kejelasan_rating' => 'integer',
        'pemahaman_jamaah_rating' => 'integer',
        'kesesuaian_waktu_rating' => 'integer',
        'interaksi_jamaah_rating' => 'integer',
    ];

    /**
     * Get relevansi rating as stars
     */
    public function getRelevansiStarsAttribute(): string
    {
        return str_repeat('★', $this->relevansi_rating) . str_repeat('☆', 5 - $this->relevansi_rating);
    }

    /**
     * Get kejelasan rating as stars
     */
    public function getKejelasanStarsAttribute(): string
    {
        return str_repeat('★', $this->kejelasan_rating) . str_repeat('☆', 5 - $this->kejelasan_rating);
    }

    /**
     * Get pemahaman jamaah rating as stars
     */
    public function getPemahamanJamaahStarsAttribute(): string
    {
        return str_repeat('★', $this->pemahaman_jamaah_rating) . str_repeat('☆', 5 - $this->pemahaman_jamaah_rating);
    }

    /**
     * Get kesesuaian waktu rating as stars
     */
    public function getKesesuaianWaktuStarsAttribute(): string
    {
        return str_repeat('★', $this->kesesuaian_waktu_rating) . str_repeat('☆', 5 - $this->kesesuaian_waktu_rating);
    }

    /**
     * Get interaksi jamaah rating as stars
     */
    public function getInteraksiJamaahStarsAttribute(): string
    {
        return str_repeat('★', $this->interaksi_jamaah_rating) . str_repeat('☆', 5 - $this->interaksi_jamaah_rating);
    }

    /**
     * Get average rating
     */
    public function getAverageRatingAttribute(): float
    {
        $ratings = [
            $this->relevansi_rating,
            $this->kejelasan_rating,
            $this->pemahaman_jamaah_rating,
            $this->kesesuaian_waktu_rating,
            $this->interaksi_jamaah_rating,
        ];

        $validRatings = array_filter($ratings, fn($rating) => !is_null($rating));
        return count($validRatings) > 0 ? round(array_sum($validRatings) / count($validRatings), 1) : 0;
    }

    /**
     * Get average rating as stars
     */
    public function getAverageStarsAttribute(): string
    {
        $average = round($this->average_rating); // Round to nearest integer
        return str_repeat('★', $average) . str_repeat('☆', 5 - $average);
    }

    /**
     * Get rating color class for a specific rating
     */
    private function getRatingColor($rating): string
    {
        return match($rating) {
            1, 2 => 'text-red-500',
            3 => 'text-yellow-500',
            4, 5 => 'text-green-500',
            default => 'text-gray-500'
        };
    }

    /**
     * Get relevansi rating color class
     */
    public function getRelevansiRatingColorAttribute(): string
    {
        return $this->getRatingColor($this->relevansi_rating);
    }

    /**
     * Get kejelasan rating color class
     */
    public function getKejelasanRatingColorAttribute(): string
    {
        return $this->getRatingColor($this->kejelasan_rating);
    }

    /**
     * Get pemahaman jamaah rating color class
     */
    public function getPemahamanJamaahRatingColorAttribute(): string
    {
        return $this->getRatingColor($this->pemahaman_jamaah_rating);
    }

    /**
     * Get kesesuaian waktu rating color class
     */
    public function getKesesuaianWaktuRatingColorAttribute(): string
    {
        return $this->getRatingColor($this->kesesuaian_waktu_rating);
    }

    /**
     * Get interaksi jamaah rating color class
     */
    public function getInteraksiJamaahRatingColorAttribute(): string
    {
        return $this->getRatingColor($this->interaksi_jamaah_rating);
    }

    /**
     * Get created_at in WIB timezone
     */
    public function getCreatedAtWibAttribute(): Carbon
    {
        return Carbon::instance($this->created_at->setTimezone('Asia/Jakarta'));
    }

    /**
     * Get updated_at in WIB timezone
     */
    public function getUpdatedAtWibAttribute(): Carbon
    {
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
     * Scope for filtering by relevansi rating
     */
    public function scopeByRelevansiRating($query, $rating)
    {
        return $query->where('relevansi_rating', $rating);
    }

    /**
     * Scope for filtering by kejelasan rating
     */
    public function scopeByKejelasanRating($query, $rating)
    {
        return $query->where('kejelasan_rating', $rating);
    }

    /**
     * Scope for filtering by pemahaman jamaah rating
     */
    public function scopeByPemahamanJamaahRating($query, $rating)
    {
        return $query->where('pemahaman_jamaah_rating', $rating);
    }

    /**
     * Scope for filtering by kesesuaian waktu rating
     */
    public function scopeByKesesuaianWaktuRating($query, $rating)
    {
        return $query->where('kesesuaian_waktu_rating', $rating);
    }

    /**
     * Scope for filtering by interaksi jamaah rating
     */
    public function scopeByInteraksiJamaahRating($query, $rating)
    {
        return $query->where('interaksi_jamaah_rating', $rating);
    }

    /**
     * Scope for recent feedbacks
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
