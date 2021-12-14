<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Hotel extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_hotel',
        'score', 
        'lokasi', 
        'alamat',
        'img_url',
        'latitude',
        'longtitude'
    ];

    public function getCreatedAtAttribute()
    {
        if(!is_null($this->attributes['created_at'])) {
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    }

    public function getUpdatedAtAttribute()
    {
        if(!is_null($this->attributes['updated_at'])) {
            return Carbon::parse($this->attributes['updated_at'])->format('Y-m-d H:i:s');
        }
    }
    /**
     * Get all of the kamars for the Hotel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kamars()
    {
        return $this->hasMany(Kamar::class);
    }

    /**
     * Get all of the reviews for the Hotel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get all of the kamars for the Hotel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fasilitas()
    {
        return $this->hasMany(Fasilitas::class);
    }
}
