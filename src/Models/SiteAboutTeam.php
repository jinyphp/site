<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteAboutTeam extends Model
{
    use HasFactory;

    protected $table = 'site_about_team';

    protected $fillable = [
        'organization_id',
        'name',
        'position',
        'title',
        'bio',
        'email',
        'phone',
        'avatar',
        'linkedin',
        'specialties',
        'education',
        'experience',
        'sort_order',
        'is_active',
        'is_manager',
        'join_date'
    ];

    protected $casts = [
        'specialties' => 'array',
        'education' => 'array',
        'experience' => 'array',
        'is_active' => 'boolean',
        'is_manager' => 'boolean',
        'sort_order' => 'integer',
        'join_date' => 'date'
    ];

    // 소속 조직 관계
    public function organization()
    {
        return $this->belongsTo(SiteAboutOrganization::class, 'organization_id');
    }

    // 스코프: 활성화된 멤버만
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // 스코프: 관리자 멤버들
    public function scopeManagers($query)
    {
        return $query->where('is_manager', true);
    }

    // 스코프: 정렬된 멤버들
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // 풀네임 getter (직책 포함)
    public function getFullNameAttribute()
    {
        $fullName = $this->name;
        if ($this->title) {
            $fullName = $this->title . ' ' . $fullName;
        }
        return $fullName;
    }

    // 연차 계산
    public function getYearsOfServiceAttribute()
    {
        if (!$this->join_date) {
            return null;
        }

        return $this->join_date->diffInYears(now());
    }

    // 전문분야 문자열 반환
    public function getSpecialtiesStringAttribute()
    {
        if (!$this->specialties || !is_array($this->specialties)) {
            return '';
        }

        return implode(', ', $this->specialties);
    }

    // 가장 최신 학력 반환
    public function getLatestEducationAttribute()
    {
        if (!$this->education || !is_array($this->education)) {
            return null;
        }

        return collect($this->education)->sortByDesc('year')->first();
    }

    // 가장 최신 경력 반환
    public function getLatestExperienceAttribute()
    {
        if (!$this->experience || !is_array($this->experience)) {
            return null;
        }

        return collect($this->experience)->sortByDesc('end_year')->first();
    }
}