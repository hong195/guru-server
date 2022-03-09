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
     * @throws ModelNotFoundException
     * @throws NotPurchasedProductException
     */
    public function activate(DomainRequest $request)
    {
        $dto = $request->getDTO();

        $oAuthUser= $this->OAuth->getUser();

        //todo perform user insertion on event
        $user = User::firstOrNew([
            'nickname' => $oAuthUser->nickname,
        ])
            ->fill([
                'name' => $oAuthUser->name,
                'email' => $oAuthUser->email,
                'access_token' => $oAuthUser->token,
                'refresh_token' => $oAuthUser->refreshToken,
            ]);

        $user->password = bcrypt(123);
        $user->save();

        $hasPurchasedProduct = $this->marketAPI->getBuyerPurchases($this->OAuth->getAccessToken())
            ->filter(function ($purchase) {
                return $purchase['item']['id'] === Domain::PRODUCT_ID;
            })
            ->first();

        if (!$hasPurchasedProduct) {
            throw new NotPurchasedProductException();
        }

        /** @var Domain $domain */
        $domain = Domain::create([
            'url' => $dto->getUrl(),
            'product_id' => $dto->getProductID(),
            'status' => 'unactivated',
        ]);

        $domain->activate();
        $domain->setCode($hasPurchasedProduct['code']);
        $domain->save();

        dispatch();
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
