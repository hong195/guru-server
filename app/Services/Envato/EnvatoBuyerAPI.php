<?php

namespace App\Services\Envato;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class EnvatoBuyerAPI
{
    private string $apiBaseUrl;

    private Collection $items;

    public function __construct(private string $accessToken)
    {
        $this->apiBaseUrl = $this->getBaseMarketUrl();
        $this->items = collect([]);
    }

    public function getBuyerPurchases(): Collection
    {
        if ($this->items->isNotEmpty()) {
            return $this->items;
        }

        $listOfPurchases = Arr::get(
                Http::withToken($this->accessToken)
                    ->get($this->apiBaseUrl . '/list-purchases')
                    ->json(),
                'results', []);

        $this->items = collect($listOfPurchases)->reverse();

        return $this->items;
    }

    public function getBuyerPurchaseByProductId(int $productId): Collection
    {
        return $this->getBuyerPurchases()
            ->filter(function ($purchase) use ($productId){
                return $purchase['item']['id'] === $productId;
            });
    }

    public function hasBuyerPurchasedProduct(int $productId): bool
    {
        return $this->getBuyerPurchases()
            ->contains(function ($purchase) use ($productId){
                return $purchase['item']['id'] === $productId;
            });
    }

    private function getBaseMarketUrl(): string
    {
        return config('services.envato.api_url') . '/market/buyer';
    }
}
