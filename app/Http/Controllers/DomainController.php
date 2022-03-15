<?php

namespace App\Http\Controllers;

use App\DTO\DomainDTO;
use App\Events\EnvatoUserAuthorized;
use App\Exceptions\DomainHasBeenAlreadyActivated;
use App\Exceptions\NotPurchasedProductException;
use App\Http\Requests\DomainRequest;
use App\Http\Requests\ReActivateDomainRequest;
use App\Services\Domain\DomainService;
use App\Services\Interfaces\OAuthInterface;
use Illuminate\Support\Str;

class DomainController extends Controller
{
    private DomainService $domainService;

    public function __construct(private OAuthInterface $oAuth)
    {
        $this->domainService = app()->make(DomainService::class, ['accessToken' => $oAuth->getAccessToken()]);;
    }

    public function activate(DomainRequest $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $dto = DomainDTO::fromArray([
            Str::replace(['http://', 'https://'], '', $request->validated('state')),
            $this->oAuth->getUser()->nickname,
        ]);

        $wpAdminUrl = $request->validated('state') . '/wp-admin/admin.php?page=bftow_settings';

        try {
            $this->domainService->activate($dto);

            return response()->redirectTo($wpAdminUrl);

        } catch (DomainHasBeenAlreadyActivated $e) {

            if ($dto->getUrl() === $e->getDomainUrl()) {
                return redirect()->away($wpAdminUrl);
            }

            return view('errors.plugin-was-already-activated', [
                'newDomain' => $dto->getUrl(),
                'activatedDomain' => $e->getDomainUrl(),
            ]);
        } catch (NotPurchasedProductException $e) {
            return view('errors.activation', [
                'title' => 'Activation error, looks like you did not purchase plugin',
                'description' => '<a href="https://codecanyon.net/item/bot-for-telegram-on-woocommerce-pro/31778602">
                            Purchase plugin</a>',
            ]);
        } finally {
            EnvatoUserAuthorized::dispatch($this->oAuth->getUser());
        }
    }

    public function reActivate(ReActivateDomainRequest $request): string
    {
        $this->domainService->deActivate($request->validated('old_domain'));

        return response()->redirectTo(route('domain/activate', [
            'state' => $request->validated('new_domain')
        ]));
    }
}
