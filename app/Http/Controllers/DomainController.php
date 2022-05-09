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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class DomainController extends Controller
{
    public function __construct(private OAuthInterface $oAuth, private DomainService $domainService )
    {
    }

    public function activate(DomainRequest $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        try {
            $dto = DomainDTO::fromArray([
                $request->validated('state'),
                $this->oAuth->getUser()->nickname,
            ]);
        }catch (\Exception $e) {
            return 1;
        }

        $wpAdminUrl = $dto->getFullUrl() . '/wp-admin/admin.php?page=bftow_settings';

        try {
            $this->domainService->activate($dto, $this->oAuth->getAccessToken());

            return Redirect::away("$wpAdminUrl");

        } catch (DomainHasBeenAlreadyActivated $e) {

            if ($dto->getUrl() === $e->getDomainUrl()) {
                return Redirect::away($wpAdminUrl);
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

        return Redirect::route('auth/redirect', [
            'domain' => $request->validated('new_domain')
        ]);
    }

    public function verify(Request $request): \Illuminate\Http\JsonResponse
    {
        $url = Str::replace(['http://', 'https://'], '', $request->get('domain'));

        return response()->json([
            'verified' => $this->domainService->verify($url),
        ]);
    }
}
