<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SitePage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'site_pages';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'status',
        'is_featured',
        'view_count',
        'sort_order',
        'template',
        'layout',
        'header',
        'footer',
        'sidebar',
        'custom_fields',
        'published_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'custom_fields' => 'array',
        'is_featured' => 'boolean',
        'view_count' => 'integer',
        'sort_order' => 'integer',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $dates = [
        'published_at',
        'deleted_at',
    ];

    // 상태 상수
    const STATUS_PUBLISHED = 'published';
    const STATUS_DRAFT = 'draft';
    const STATUS_PRIVATE = 'private';

    // 부트 메서드 - 자동으로 slug 생성
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }

            // slug 중복 체크 및 번호 추가
            $originalSlug = $page->slug;
            $count = 2;
            while (static::where('slug', $page->slug)->exists()) {
                $page->slug = $originalSlug . '-' . $count;
                $count++;
            }

            if (auth()->check()) {
                $page->created_by = auth()->id();
            }
        });

        static::updating(function ($page) {
            if (auth()->check()) {
                $page->updated_by = auth()->id();
            }
        });
    }

    // 관계
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }

    public function contents()
    {
        return $this->hasMany(SitePageContent::class, 'page_id')->ordered();
    }

    public function activeContents()
    {
        return $this->hasMany(SitePageContent::class, 'page_id')->active()->ordered();
    }

    // 스코프
    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED)
                    ->where(function ($q) {
                        $q->whereNull('published_at')
                          ->orWhere('published_at', '<=', now());
                    });
    }

    public function scopeDraft($query)
    {
        return $query->where('status', self::STATUS_DRAFT);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
    }

    // 접근자 (Accessors)
    public function getIsPublishedAttribute()
    {
        return $this->status === self::STATUS_PUBLISHED &&
               ($this->published_at === null || $this->published_at <= now());
    }

    public function getMetaTitleAttribute($value)
    {
        return $value ?: $this->title;
    }

    public function getOgTitleAttribute($value)
    {
        return $value ?: $this->meta_title;
    }

    public function getUrlAttribute()
    {
        return '/' . $this->slug;
    }

    // 변경자 (Mutators)
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    // 메서드
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            self::STATUS_PUBLISHED => 'bg-success',
            self::STATUS_DRAFT => 'bg-warning',
            self::STATUS_PRIVATE => 'bg-secondary',
            default => 'bg-light text-dark'
        };
    }

    public function getStatusLabel()
    {
        return match($this->status) {
            self::STATUS_PUBLISHED => '발행됨',
            self::STATUS_DRAFT => '임시저장',
            self::STATUS_PRIVATE => '비공개',
            default => '알 수 없음'
        };
    }

    public function canBePublished()
    {
        return !empty($this->title) && !empty($this->content);
    }

    public function getReadingTime()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $readingTimeMinutes = ceil($wordCount / 200); // 분당 약 200단어 읽는다고 가정
        return $readingTimeMinutes;
    }

    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }

        // content에서 자동으로 excerpt 생성
        $content = strip_tags($this->content);
        return Str::limit($content, 160);
    }
}