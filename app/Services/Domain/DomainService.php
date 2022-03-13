<?php

namespace App\Services\Domain;

use App\DTO\DomainDTO;
use App\Exceptions\DomainHasBeenAlreadyActivated;
use App\Exceptions\NotPurchasedProductException;
use App\Models\Domain;
use App\Services\Envato\EnvatoBuyerAPI;
use App\Services\Interfaces\OAuthInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DomainService
{
    private EnvatoBuyerAPI $envatoBuyerAPI;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(private OAuthInterface $oAuth)
    {
        $this->envatoBuyerAPI = app()->make(EnvatoBuyerAPI::class, ['token' => $this->oAuth->getAccessToken()]);
    }

    /**
     * @throws ModelNotFoundException
     * @throws NotPurchasedProductException
     * @throws DomainHasBeenAlreadyActivated
     */
    public function activate(DomainDTO $dto)
    {
        if (Domain::isActivated($dto->getUrl())->exists()) {
            throw new DomainHasBeenAlreadyActivated();
        }

        if (!$this->envatoBuyerAPI->hasBuyerPurchasedProduct(Domain::PRO_PLUGIN_PRODUCT_ID)) {
            throw new NotPurchasedProductException();
        }

        /** @var Domain $domain */
        $domain = Domain::create([
            'url' => $dto->getUrl(),
            'product_id' => $dto->getProductID(),
            'status' => 'unactivated',
        ]);

        $domain->activate();
        $domain->setCode($this->envatoBuyerAPI->hasBuyerPurchasedProduct(Domain::PRO_PLUGIN_PRODUCT_ID));
        $domain->save();
    }

    /**
     * @throws ModelNotFoundException
     */
    public function deActivate(DomainDTO $dto)
    {
        $domain = Domain::isActivated($dto->getUrl())->firstOrFail();

        $domain->remove();
    }
}
