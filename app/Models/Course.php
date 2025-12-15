<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'duration_hours',
        'price',
        'start_date',
        'end_date',
        'cover_image_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'decimal:2',
    ];

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'course_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'course_id');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class, 'course_id');
    }

    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image_path ? asset('images/' . $this->cover_image_path) : null;
    }
}
