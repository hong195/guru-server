<?php

namespace App\Services\Domain;

use App\DTO\DomainDTO;
use App\Events\DomainActivated;
use App\Events\DomainDeactivated;
use App\Exceptions\DomainHasBeenAlreadyActivated;
use App\Exceptions\NotPurchasedProductException;
use App\Models\Domain;
use App\Services\Envato\EnvatoBuyerAPI;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DomainService
{
    /**
     * @throws ModelNotFoundException
     * @throws NotPurchasedProductException
     * @throws DomainHasBeenAlreadyActivated
     */
    public function activate(DomainDTO $dto, string $accessToken)
    {
        /** @var EnvatoBuyerAPI $envatoBuyerAPI */
        $envatoBuyerAPI = app()->make(EnvatoBuyerAPI::class, ['accessToken' => $accessToken]);

        $activatedDomain = Domain::isActivated($dto->getUserNickname())->first();

        if ($activatedDomain) {
            throw new DomainHasBeenAlreadyActivated(domainUrl: $this->cleanUrl($activatedDomain->url));
        }

        if (!$envatoBuyerAPI->hasBuyerPurchasedProduct(Domain::PRO_PLUGIN_PRODUCT_ID)) {
            throw new NotPurchasedProductException();
        }

        /** @var Domain $domain */
        $domain = Domain::firstOrNew([
            'url' => $this->cleanUrl($dto->getUrl()),
            'product_id' => Domain::PRO_PLUGIN_PRODUCT_ID,
            'user_nickname' => $dto->getUserNickname()
        ]);

        $purchasedProduct = $envatoBuyerAPI->getBuyerPurchaseByProductId(Domain::PRO_PLUGIN_PRODUCT_ID)->first();
        $domain->activate();
        $domain->setCode(Arr::get($purchasedProduct, 'code'));
        $domain->save();

        DomainActivated::dispatch($domain);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function deActivate(string $domainUrl)
    {
        /** @var Domain $domain */
        $domain = Domain::where('url', $domainUrl)->firstOrFail();
        $domain->deactivate();

        DomainDeactivated::dispatch($domainUrl);
    }

    public function verify(string $domainUrl)
    {
        return Domain::where('url', $domainUrl)->where('status', Domain::ACTIVATED_STATUS)->exists();
    }

    public function cleanUrl(string $url): string
    {
        return Str::replace(['http://', 'https://'], '', $url);
    }
}
