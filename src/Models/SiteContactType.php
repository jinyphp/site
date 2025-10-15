<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SiteContactType extends Model
{
    protected $table = 'site_contact_types';

    protected $fillable = [
        'name',
        'description',
        'enable',
        'sort_order'
    ];

    protected $casts = [
        'enable' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * 활성화된 상담 유형만 조회
     */
    public function scopeEnabled($query)
    {
        return $query->where('enable', true);
    }

    /**
     * 정렬 순서로 조회
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * 상담 요청과의 관계
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(SiteContact::class, 'contact_type_id');
    }

    /**
     * 활성화된 상담 요청과의 관계
     */
    public function activeContacts(): HasMany
    {
        return $this->hasMany(SiteContact::class, 'contact_type_id')
                    ->whereIn('status', ['pending', 'processing']);
    }
}