<?php

namespace App\Services\Domain;

use App\Exceptions\ExistingDomainException;
use App\Exceptions\NotPurchasedProductException;
use App\Http\Requests\DomainRequest;
use App\Models\Domain;
use App\Models\User;
use App\Services\Envato\EnvatoMarketAPI;
use App\Services\OAuth\EnvatoOAuth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DomainService
{
    public function __construct(private EnvatoMarketAPI $marketAPI, private EnvatoOAuth $OAuth)
    {
    }

    /**
     * @throws ExistingDomainException
     */
    public function request(DomainRequest $request)
    {
        $dto = $request->getDTO();

        /** @var Domain $domain */
        $domain = Domain::where('product_id', $dto->getProductID())
            ->andWhere('url', $dto->getUrl())
            ->first();

        $isDomainAlreadyExists = $domain->exists();

        if ($domain->isRegistered()) {
            //TODO tell user that he has been already registered product
        }

        if ($isDomainAlreadyExists) {
            throw new ExistingDomainException();
        }

        Domain::request($dto->getUrl(), $dto->getProductID());
    }

    /**
     * @throws ModelNotFoundException
     * @throws NotPurchasedProductException
     */
    public function register(DomainRequest $request)
    {
        $dto = $request->getDTO();

        /** @var Domain $domain */
        $domain = Domain::where('product_id', $dto->getProductID())
            ->andWhere('url', $dto->getUrl())
            ->findOrFail();

        $user = $this->OAuth->getUser();

        //todo perform user insertion on event
        User::firstOrCreate([
            'name' => $user->name,
        ])
            ->fill([
                'nickname' => $user->nickname,
                'access_token' => $user->token,
                'refresh_token' => $user->refreshToken,
                'password' => bcrypt(123)
            ])
            ->save();

        $purchasedProduct = $this->marketAPI->getBuyerPurchases($user->token)
            ->filter(function ($purchase) use ($domain) {
                return $purchase['item']['id'] === $domain->product_id;
            })
            ->first();

        if (!$purchasedProduct) {
            throw new NotPurchasedProductException;
        }

        $domain->setCode($purchasedProduct['code']);
        $domain->register();
        $domain->save();

        ///fire events after completion
    }

    /**
     * @throws ModelNotFoundException
     */
    public function deRegister(DomainRequest $request)
    {
        $dto = $request->getDTO();

        $domain = Domain::where('product_id', $dto->getProductID())
            ->andWhere('url', $dto->getUrl())
            ->firstOrFail();

        $domain->remove();
    }
}
