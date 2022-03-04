<?php

namespace App\Services\Envato;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class EnvatoMarketAPI
{
    private string $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = $this->getBaseMarketUrl();
    }

    public function getBuyerPurchases(string $token): \Illuminate\Support\Collection
    {
        $listOfPurchases = Arr::get(
                Http::withToken($token)
                    ->get($this->apiBaseUrl . '/list-purchases')
                    ->json(),
                'results', []);

        return collect($listOfPurchases);
    }

    private function getBaseMarketUrl(): string
    {
        return config('services.envato.api_url') . '/market/buyer';
    }
}
