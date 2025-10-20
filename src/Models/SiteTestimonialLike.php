<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteTestimonialLike extends Model
{
    use HasFactory;

    protected $table = 'site_testimonial_likes';

    protected $fillable = [
        'testimonial_id',
        'user_id',
        'ip_address',
    ];

    /**
     * 후기 관계
     */
    public function testimonial()
    {
        return $this->belongsTo(SiteTestimonial::class, 'testimonial_id');
    }

    /**
     * 사용자 관계
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}