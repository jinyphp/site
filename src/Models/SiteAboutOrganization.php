<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteAboutOrganization extends Model
{
    use HasFactory;

    protected $table = 'site_about_organization';

    protected $fillable = [
        'name',
        'code',
        'description',
        'parent_id',
        'sort_order',
        'level',
        'is_active',
        'manager_title',
        'contact_email',
        'contact_phone'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'level' => 'integer'
    ];

    // 상위 조직 관계
    public function parent()
    {
        return $this->belongsTo(SiteAboutOrganization::class, 'parent_id');
    }

    // 하위 조직들 관계
    public function children()
    {
        return $this->hasMany(SiteAboutOrganization::class, 'parent_id')->where('is_active', true)->orderBy('sort_order');
    }

    // 모든 하위 조직들 (재귀)
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    // 팀 구성원들 관계
    public function teamMembers()
    {
        return $this->hasMany(SiteAboutOrganizationMember::class, 'organization_id')->where('is_active', true)->orderBy('sort_order');
    }

    // 모든 팀 구성원들 (비활성 포함)
    public function allTeamMembers()
    {
        return $this->hasMany(SiteAboutOrganizationMember::class, 'organization_id')->orderBy('sort_order');
    }

    // 스코프: 활성화된 조직만
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // 스코프: 최상위 조직들 (parent_id가 null)
    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    // 스코프: 정렬된 조직들
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // 전체 조직 트리 가져오기
    public static function getOrganizationTree()
    {
        return static::active()
            ->roots()
            ->ordered()
            ->with(['allChildren.teamMembers', 'teamMembers'])
            ->get();
    }

    // 조직의 전체 경로 가져오기 (breadcrumb용)
    public function getFullPath()
    {
        $path = [];
        $current = $this;

        while ($current) {
            array_unshift($path, $current->name);
            $current = $current->parent;
        }

        return implode(' > ', $path);
    }
}
