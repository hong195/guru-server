<?php

namespace App\Services\Domain;

use App\DTO\DomainDTO;
use Illuminate\Support\Facades\Http;

class WPSyncService
{
    public function sync(DomainDTO $dto)
    {
        $response = Http::post($dto->getUrl(), [
            ''
        ])
                    ->json();
    }
}
