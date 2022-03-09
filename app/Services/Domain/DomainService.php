<?php

namespace App\Services\Domain;

use App\Exceptions\DomainIsAlreadyRequested;
use App\Exceptions\NotPurchasedProductException;
use App\Http\Requests\DomainRequest;
use App\Models\Domain;
use App\Models\User;
use App\Services\Envato\EnvatoMarketAPI;
use App\Services\Interfaces\OAuthInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DomainService
{
    public function __construct(private EnvatoMarketAPI $marketAPI, private OAuthInterface $OAuth)
    {
    }

    /**
     * @throws DomainIsAlreadyRequested
     */
    public function request(DomainRequest $request)
    {
        $dto = $request->getDTO();
        /** @var Domain $domain */
        $domainIsAlreadyRequested = Domain::where('url', $dto->getUrl())->first();

        if ($domainIsAlreadyRequested) {
            throw new DomainIsAlreadyRequested();
        }

        Domain::request($dto->getUrl(), $dto->getProductID());

        return $this->OAuth->redirect();
    }

    /**
     * @throws ModelNotFoundException
     * @throws NotPurchasedProductException
     */
    public function activate(Request $request)
    {
        dd($request);
        $dto = $request->getDTO();

        /** @var Domain $domain */
        $domain = Domain::where('url', $dto->getUrl())->firstOrFail();

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

        $hasPurchasedProduct = $this->marketAPI->getBuyerPurchases($user->token)
            ->filter(function ($purchase) use ($domain) {
                return $purchase['item']['id'] === Domain::PRODUCT_ID;
            })
            ->first();

        if (!$hasPurchasedProduct) {
            throw new NotPurchasedProductException;
        }

        $domain->setCode($hasPurchasedProduct['code']);
        $domain->register();
        $domain->save();
        ///fire events after completion
    }

    /**
     * @throws ModelNotFoundException
     */
    public function deActivate(DomainRequest $request)
    {
        $dto = $request->getDTO();

        $domain = Domain::where('url', $dto->getUrl())->firstOrFail();

        $domain->remove();
    }
}
