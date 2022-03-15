<?php

namespace App\Services\Domain;

use App\DTO\DomainDTO;
use App\Events\DomainActivated;
use App\Exceptions\DomainHasBeenAlreadyActivated;
use App\Exceptions\NotPurchasedProductException;
use App\Models\Domain;
use App\Services\Envato\EnvatoBuyerAPI;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class DomainService
{
    private EnvatoBuyerAPI $envatoBuyerAPI;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(private string $accessToken)
    {
        $this->envatoBuyerAPI = app()->make(EnvatoBuyerAPI::class, ['accessToken' => $accessToken]);
    }

    /**
     * @throws ModelNotFoundException
     * @throws NotPurchasedProductException
     * @throws DomainHasBeenAlreadyActivated
     */
    public function activate(DomainDTO $dto)
    {
        $activatedDomain = Domain::isActivated($dto->getUserNickname())->first();

        if ($activatedDomain) {
            throw new DomainHasBeenAlreadyActivated(domainUrl: $this->cleanUrl($activatedDomain->url));
        }

        if (!$this->envatoBuyerAPI->hasBuyerPurchasedProduct(Domain::PRO_PLUGIN_PRODUCT_ID)) {
            throw new NotPurchasedProductException();
        }

        /** @var Domain $domain */
        $domain = Domain::firstOrNew([
            'url' => $this->cleanUrl($dto->getUrl()),
            'product_id' => Domain::PRO_PLUGIN_PRODUCT_ID,
            'user_nickname' => $dto->getUserNickname()
        ]);

        $domain->activate();
        $domain->setCode($this->envatoBuyerAPI->hasBuyerPurchasedProduct(Domain::PRO_PLUGIN_PRODUCT_ID));
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
    }

    public function cleanUrl(string $url): string
    {
        return Str::replace(['http://', 'https://'], '', $url);
    }
}
