<?php

namespace Jiny\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteExchangeRate extends Model
{
    use HasFactory;

    protected $table = 'site_exchange_rates';

    protected $fillable = [
        'from_currency',
        'to_currency',
        'rate',
        'inverse_rate',
        'source',
        'provider',
        'rate_date',
        'expires_at',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'rate' => 'decimal:8',
        'inverse_rate' => 'decimal:8',
        'rate_date' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * 활성화된 환율만 조회
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * 만료되지 않은 환율만 조회
     */
    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    /**
     * 유효한 환율 조회 (활성화되고 만료되지 않은)
     */
    public function scopeValid($query)
    {
        return $query->active()->notExpired();
    }

    /**
     * 특정 통화 쌍 조회
     */
    public function scopeCurrencyPair($query, $fromCurrency, $toCurrency)
    {
        return $query->where('from_currency', $fromCurrency)
                    ->where('to_currency', $toCurrency);
    }

    /**
     * 제공업체별 조회
     */
    public function scopeByProvider($query, $provider)
    {
        return $query->where('provider', $provider);
    }

    /**
     * 출발 통화 정보와의 관계
     */
    public function fromCurrencyInfo()
    {
        return $this->belongsTo(SiteCurrency::class, 'from_currency', 'code');
    }

    /**
     * 목적지 통화 정보와의 관계
     */
    public function toCurrencyInfo()
    {
        return $this->belongsTo(SiteCurrency::class, 'to_currency', 'code');
    }

    /**
     * 환율이 만료되었는지 확인
     */
    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * 환율이 유효한지 확인
     */
    public function isValid()
    {
        return $this->is_active && !$this->isExpired();
    }

    /**
     * 특정 금액 환전 계산
     */
    public function convertAmount($amount)
    {
        return $amount * $this->rate;
    }

    /**
     * 역방향 환전 계산
     */
    public function convertAmountInverse($amount)
    {
        return $amount * $this->inverse_rate;
    }

    /**
     * 환율 변동률 계산 (이전 환율과 비교)
     */
    public function getChangePercentage($previousRate)
    {
        if (!$previousRate || $previousRate == 0) {
            return 0;
        }

        return (($this->rate - $previousRate) / $previousRate) * 100;
    }

    /**
     * 환율 포맷팅
     */
    public function getFormattedRateAttribute()
    {
        return number_format($this->rate, 4);
    }

    /**
     * 역환율 포맷팅
     */
    public function getFormattedInverseRateAttribute()
    {
        return number_format($this->inverse_rate, 4);
    }

    /**
     * 통화 쌍 표시명
     */
    public function getCurrencyPairAttribute()
    {
        return $this->from_currency . '/' . $this->to_currency;
    }

    /**
     * 환율 상태 표시
     */
    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'inactive';
        }

        if ($this->isExpired()) {
            return 'expired';
        }

        return 'active';
    }

    /**
     * 환율 만료까지 남은 시간 (분 단위)
     */
    public function getMinutesToExpirationAttribute()
    {
        if (!$this->expires_at) {
            return null;
        }

        return now()->diffInMinutes($this->expires_at, false);
    }

    /**
     * 최신 유효한 환율 가져오기
     */
    public static function getLatestRate($fromCurrency, $toCurrency)
    {
        return static::currencyPair($fromCurrency, $toCurrency)
                    ->valid()
                    ->orderBy('rate_date', 'desc')
                    ->first();
    }

    /**
     * 환율 업데이트 또는 생성
     */
    public static function updateOrCreate($fromCurrency, $toCurrency, $rate, $provider = 'manual', $expiresInHours = 24)
    {
        $inverseRate = $rate > 0 ? 1 / $rate : 0;
        $expiresAt = $expiresInHours ? now()->addHours($expiresInHours) : null;

        return static::updateOrCreate(
            [
                'from_currency' => $fromCurrency,
                'to_currency' => $toCurrency,
                'provider' => $provider,
            ],
            [
                'rate' => $rate,
                'inverse_rate' => $inverseRate,
                'rate_date' => now(),
                'expires_at' => $expiresAt,
                'is_active' => true,
                'source' => 'api',
            ]
        );
    }

    /**
     * 환율 히스토리 가져오기
     */
    public static function getHistory($fromCurrency, $toCurrency, $days = 30)
    {
        return static::currencyPair($fromCurrency, $toCurrency)
                    ->where('rate_date', '>=', now()->subDays($days))
                    ->orderBy('rate_date', 'desc')
                    ->get();
    }

    /**
     * 만료된 환율 정리
     */
    public static function cleanupExpiredRates($deleteOlderThanDays = 30)
    {
        return static::where('expires_at', '<', now()->subDays($deleteOlderThanDays))
                    ->delete();
    }

    /**
     * 환율 비활성화
     */
    public function deactivate()
    {
        $this->is_active = false;
        $this->save();

        return $this;
    }

    /**
     * 환율 활성화
     */
    public function activate()
    {
        $this->is_active = true;
        $this->save();

        return $this;
    }

    /**
     * 환율 만료 연장
     */
    public function extendExpiration($hours = 24)
    {
        $this->expires_at = now()->addHours($hours);
        $this->save();

        return $this;
    }

    /**
     * 환율 요약 정보
     */
    public function getSummaryAttribute()
    {
        return [
            'currency_pair' => $this->currency_pair,
            'rate' => $this->formatted_rate,
            'inverse_rate' => $this->formatted_inverse_rate,
            'provider' => $this->provider,
            'status' => $this->status,
            'rate_date' => $this->rate_date->format('Y-m-d H:i:s'),
            'expires_at' => $this->expires_at?->format('Y-m-d H:i:s'),
            'minutes_to_expiration' => $this->minutes_to_expiration,
        ];
    }
}