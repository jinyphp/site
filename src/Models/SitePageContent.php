<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SitePageContent extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'site_page_content';

    protected $fillable = [
        'page_id',
        'block_type',
        'title',
        'content',
        'settings',
        'sort_order',
        'is_active',
        'css_class',
        'attributes',
        'hide_title',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'settings' => 'array',
        'attributes' => 'array',
        'is_active' => 'boolean',
        'hide_title' => 'boolean',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $dates = [
        'deleted_at',
    ];

    // 블럭 타입 상수
    const TYPE_TEXT = 'text';
    const TYPE_BLADE = 'blade';
    const TYPE_HTML = 'html';
    const TYPE_MARKDOWN = 'markdown';
    const TYPE_IMAGE = 'image';
    const TYPE_VIDEO = 'video';
    const TYPE_COMPONENT = 'component';
    const TYPE_DIVIDER = 'divider';
    const TYPE_CODE = 'code';

    // 부트 메서드
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($content) {
            if (auth()->check()) {
                $content->created_by = auth()->id();
            }

            // 자동으로 sort_order 설정
            if (empty($content->sort_order)) {
                $maxOrder = static::where('page_id', $content->page_id)
                    ->max('sort_order');
                $content->sort_order = ($maxOrder ?? 0) + 1;
            }
        });

        static::updating(function ($content) {
            if (auth()->check()) {
                $content->updated_by = auth()->id();
            }
        });
    }

    // 관계
    public function page()
    {
        return $this->belongsTo(SitePage::class, 'page_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }

    // 스코프
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('block_type', $type);
    }

    public function scopeForPage($query, $pageId)
    {
        return $query->where('page_id', $pageId);
    }

    // 접근자 (Accessors)
    public function getRenderedContentAttribute()
    {
        return $this->renderContent();
    }

    public function getBlockTypeNameAttribute()
    {
        return match($this->block_type) {
            self::TYPE_TEXT => '텍스트',
            self::TYPE_BLADE => 'Blade 템플릿',
            self::TYPE_HTML => 'HTML',
            self::TYPE_MARKDOWN => 'Markdown',
            self::TYPE_IMAGE => '이미지',
            self::TYPE_VIDEO => '비디오',
            self::TYPE_COMPONENT => '컴포넌트',
            self::TYPE_DIVIDER => '구분선',
            self::TYPE_CODE => '코드',
            default => '알 수 없음'
        };
    }

    public function getBlockTypeIconAttribute()
    {
        return match($this->block_type) {
            self::TYPE_TEXT => 'fas fa-font',
            self::TYPE_BLADE => 'fab fa-laravel',
            self::TYPE_HTML => 'fab fa-html5',
            self::TYPE_MARKDOWN => 'fab fa-markdown',
            self::TYPE_IMAGE => 'fas fa-image',
            self::TYPE_VIDEO => 'fas fa-video',
            self::TYPE_COMPONENT => 'fas fa-puzzle-piece',
            self::TYPE_DIVIDER => 'fas fa-minus',
            self::TYPE_CODE => 'fas fa-code',
            default => 'fas fa-question'
        };
    }

    // 메서드
    public function renderContent()
    {
        try {
            switch ($this->block_type) {
                case self::TYPE_TEXT:
                    return nl2br(e(str_replace('\\n', "\n", $this->content)));

                case self::TYPE_HTML:
                    return $this->content;

                case self::TYPE_MARKDOWN:
                    if (class_exists('\Parsedown')) {
                        $parsedown = new \Parsedown();
                        return $parsedown->text($this->content);
                    }
                    return nl2br(e($this->content));

                case self::TYPE_BLADE:
                    // includeIf() 방식으로 처리 - 뷰 이름은 package::view.name 또는 folder.subfolder.viewname 형식
                    $viewName = trim($this->content);
                    if (empty($viewName)) {
                        return '<div class="alert alert-warning">Blade 템플릿 이름이 비어있습니다.</div>';
                    }

                    // 뷰 이름 형식 검증 (:: 또는 . 포함)
                    if (!preg_match('/^[a-zA-Z0-9_\-]+(::[a-zA-Z0-9_\-\.]+|\.[\w\.\-]+)$/', $viewName)) {
                        return '<div class="alert alert-warning">잘못된 뷰 이름 형식입니다. package::view.name 또는 folder.subfolder.viewname 형식으로 입력하세요: ' . e($viewName) . '</div>';
                    }

                    // includeIf와 같은 방식으로 처리: 뷰가 존재할 때만 렌더링
                    if (view()->exists($viewName)) {
                        return view($viewName, $this->settings ?? [])->render();
                    }

                    // 뷰가 존재하지 않을 때는 조용히 빈 문자열 반환 (includeIf 동작과 동일)
                    return '';

                case self::TYPE_IMAGE:
                    $alt = $this->settings['alt'] ?? $this->title ?? '';
                    $cssClass = $this->css_class ? ' class="' . e($this->css_class) . '"' : '';
                    return '<img src="' . e($this->content) . '" alt="' . e($alt) . '"' . $cssClass . '>';

                case self::TYPE_VIDEO:
                    $cssClass = $this->css_class ? ' class="' . e($this->css_class) . '"' : '';
                    return '<video src="' . e($this->content) . '" controls' . $cssClass . '></video>';

                case self::TYPE_DIVIDER:
                    $cssClass = $this->css_class ?: 'border-gray-300';
                    return '<hr class="' . e($cssClass) . '">';

                case self::TYPE_CODE:
                    $language = $this->settings['language'] ?? 'text';
                    return '<pre><code class="language-' . e($language) . '">' . e($this->content) . '</code></pre>';

                case self::TYPE_COMPONENT:
                    // 커스텀 컴포넌트 렌더링 로직
                    return $this->renderComponent();

                default:
                    return e($this->content);
            }
        } catch (\Exception $e) {
            return '<div class="alert alert-danger">블럭 렌더링 오류: ' . e($e->getMessage()) . '</div>';
        }
    }

    private function renderComponent()
    {
        // 컴포넌트 렌더링 로직 구현
        $componentPath = $this->content;
        $settings = $this->settings ?? [];

        if (view()->exists($componentPath)) {
            return view($componentPath, $settings)->render();
        }

        return '<div class="alert alert-warning">컴포넌트를 찾을 수 없습니다: ' . e($componentPath) . '</div>';
    }

    public function move($direction)
    {
        $currentOrder = $this->sort_order;
        $siblingContent = null;

        if ($direction === 'up') {
            $siblingContent = static::where('page_id', $this->page_id)
                ->where('sort_order', '<', $currentOrder)
                ->orderBy('sort_order', 'desc')
                ->first();
        } elseif ($direction === 'down') {
            $siblingContent = static::where('page_id', $this->page_id)
                ->where('sort_order', '>', $currentOrder)
                ->orderBy('sort_order', 'asc')
                ->first();
        }

        if ($siblingContent) {
            $siblingOrder = $siblingContent->sort_order;

            // 순서 교환
            $this->update(['sort_order' => $siblingOrder]);
            $siblingContent->update(['sort_order' => $currentOrder]);

            return true;
        }

        return false;
    }

    public function duplicate()
    {
        $newContent = $this->replicate();
        $newContent->title = $this->title . ' (복사본)';
        $newContent->save();

        return $newContent;
    }

    public static function getAvailableTypes()
    {
        return [
            self::TYPE_TEXT => '텍스트',
            self::TYPE_HTML => 'HTML',
            self::TYPE_MARKDOWN => 'Markdown',
            self::TYPE_BLADE => 'Blade 템플릿',
            self::TYPE_IMAGE => '이미지',
            self::TYPE_VIDEO => '비디오',
            self::TYPE_DIVIDER => '구분선',
            self::TYPE_CODE => '코드',
            self::TYPE_COMPONENT => '컴포넌트',
        ];
    }
}