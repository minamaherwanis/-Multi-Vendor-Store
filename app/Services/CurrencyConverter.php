<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
    private $apiKey;

    protected $baseUrl = 'https://api.currencyapi.com/v3';

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

   public function convert(string $from, string $to, float $amount = 1): float
{
    $response = Http::baseUrl($this->baseUrl)
        ->get('/latest', [
            'apikey' => $this->apiKey,
            'base_currency' => $from,
            'currencies' => $to,
        ]);

    $result = $response->json();
        
    // قيمة العملة المطلوبة
    $rate = $result['data'][$to]['value'] ?? null;

    if (!$rate) {
        throw new \Exception("Currency conversion for {$from}_{$to} not found");
    }

    return $rate * $amount;
}

}