<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'message',
        'type',
        'link_url',
        'link_text',
        'icon',
        'background_color',
        'text_color',
        'enable',
        'start_date',
        'end_date',
        'display_order',
        'is_closable',
        'cookie_days',
    ];

    protected $casts = [
        'enable' => 'boolean',
        'is_closable' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'display_order' => 'integer',
        'cookie_days' => 'integer',
    ];

    /**
     * 활성화된 베너 조회
     */
    public function scopeActive($query)
    {
        return $query->where('enable', true);
    }

    /**
     * 현재 시점에서 유효한 베너 조회
     */
    public function scopeValid($query)
    {
        $now = Carbon::now();
        return $query->where(function ($query) use ($now) {
            $query->where(function ($q) use ($now) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', $now);
            })->where(function ($q) use ($now) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', $now);
            });
        });
    }

    /**
     * 표시 순서로 정렬
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc')->orderBy('id', 'desc');
    }

    /**
     * 베너가 현재 유효한지 확인
     */
    public function isValid(): bool
    {
        $now = Carbon::now();

        if (!$this->enable) {
            return false;
        }

        if ($this->start_date && $this->start_date->gt($now)) {
            return false;
        }

        if ($this->end_date && $this->end_date->lt($now)) {
            return false;
        }

        return true;
    }

    /**
     * 베너 타입에 따른 CSS 클래스 반환
     */
    public function getTypeClassAttribute(): string
    {
        $typeClasses = [
            'info' => 'alert-info',
            'warning' => 'alert-warning',
            'success' => 'alert-success',
            'danger' => 'alert-danger',
            'primary' => 'alert-primary',
            'secondary' => 'alert-secondary',
        ];

        return $typeClasses[$this->type] ?? 'alert-info';
    }

    /**
     * 베너 스타일 속성 반환
     */
    public function getStyleAttribute(): string
    {
        $styles = [];

        if ($this->background_color) {
            $styles[] = "background-color: {$this->background_color}";
        }

        if ($this->text_color) {
            $styles[] = "color: {$this->text_color}";
        }

        return implode('; ', $styles);
    }
}
