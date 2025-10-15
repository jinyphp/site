<?php

namespace Jiny\Site\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Jiny\Site\Services\ExchangeRateService;

class UpdateExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange-rates:update
                            {--from= : Base currency (default: KRW)}
                            {--to= : Target currency (updates all if not specified)}
                            {--provider= : API provider to use}
                            {--force : Force update even if not expired}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update exchange rates from external API';

    protected $exchangeRateService;

    public function __construct(ExchangeRateService $exchangeRateService)
    {
        parent::__construct();
        $this->exchangeRateService = $exchangeRateService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting exchange rate update...');

        $fromCurrency = $this->option('from') ?? config('site.base_currency', 'KRW');
        $toCurrency = $this->option('to');
        $provider = $this->option('provider');
        $force = $this->option('force');

        // 프로바이더 설정
        if ($provider) {
            config(['site.exchange_rate_provider' => $provider]);
            $this->info("Using provider: {$provider}");
        }

        try {
            if ($toCurrency) {
                // 특정 통화 쌍 업데이트
                $this->info("Updating {$fromCurrency} to {$toCurrency}...");
                $result = $this->exchangeRateService->updateRate($fromCurrency, $toCurrency);

                if ($result['success']) {
                    $this->info("✅ Updated {$fromCurrency}/{$toCurrency}: {$result['rate']}");
                    if (isset($result['change_percent'])) {
                        $changeColor = $result['change_percent'] >= 0 ? 'green' : 'red';
                        $this->line("   Change: <fg={$changeColor}>" .
                                   number_format($result['change_percent'], 2) . '%</fg>');
                    }
                } else {
                    $this->error("❌ Failed to update {$fromCurrency}/{$toCurrency}: {$result['message']}");
                    return 1;
                }
            } else {
                // 모든 활성화된 통화 업데이트
                $this->info("Updating all active currencies...");
                $results = $this->exchangeRateService->updateAllRates();

                $this->displayResults($results);
            }

            $this->info('Exchange rate update completed!');
            return 0;

        } catch (\Exception $e) {
            $this->error("Error: {$e->getMessage()}");
            return 1;
        }
    }

    /**
     * 결과를 테이블 형태로 표시
     */
    protected function displayResults(array $results)
    {
        $headers = ['Currency Pair', 'Status', 'Rate', 'Message'];
        $rows = [];

        foreach ($results as $result) {
            $status = $result['success'] ? '✅ Success' : '❌ Failed';
            $rate = $result['rate'] ? number_format($result['rate'], 6) : 'N/A';
            $message = Str::limit($result['message'], 50);

            $rows[] = [
                $result['currency_pair'],
                $status,
                $rate,
                $message
            ];
        }

        $this->table($headers, $rows);

        // 요약 정보
        $successCount = collect($results)->where('success', true)->count();
        $totalCount = count($results);

        $this->info("Summary: {$successCount}/{$totalCount} successful updates");
    }
}