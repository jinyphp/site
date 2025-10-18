<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteAboutOrganizationMember extends Model
{
    use HasFactory;

    protected $table = 'site_about_organization_members';

    protected $fillable = [
        'organization_id',
        'name',
        'email',
        'phone',
        'position',
        'bio',
        'photo',
        'sort_order',
        'is_active',
        'linkedin_url',
        'twitter_url',
        'github_url',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * 소속 조직과의 관계
     */
    public function organization()
    {
        return $this->belongsTo(SiteAboutOrganization::class, 'organization_id');
    }

    /**
     * 활성 팀원만 조회하는 스코프
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * 정렬 순서로 조회하는 스코프
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
    }

    /**
     * 사진 URL 반환
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return null;
    }
}