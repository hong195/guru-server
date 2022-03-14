<?php

namespace App\Http\Controllers;

use App\Exceptions\NotPurchasedProductException;
use App\Http\Requests\DomainRequest;
use App\Services\Domain\DomainService;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function __construct(private DomainService $domainService){
    }

    public function activate(DomainRequest $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $wpAdminUrl = $request->getDTO()->getUrl() . '/wp-admin/admin.php?page=bftow_settings';

        try {
            $this->domainService->activate($request->getDTO());

            return response()->redirectTo($wpAdminUrl);

        }catch (NotPurchasedProductException $e) {
            return view('errors.activation', [
                'title' => 'Activation error, you did not purchase plugin',
                'description' => '<a href="https://codecanyon.net/item/bot-for-telegram-on-woocommerce-pro/31778602">
                            Purchase plugin</a>',
            ]);
        }
    }

    public function deActivate(DomainRequest $request): string
    {
        $goBackUrl = $request->getDTO()->getUrl() . '/wp-admin/admin.php?page=bftow_settings';

        try {
            $this->domainService->deActivate($request->getDTO());
            $title = 'Plugin was successfully disconnected from ' . $request->getDTO()->getUrl() .' domain';
        }catch (NotPurchasedProductException $e) {
            $title = 'Error occurred, please try later';
        }

        return view('activation-success', [
            'description' => '<a href='. $goBackUrl .'>Go back to my amdin panel</a>',
            'title' => $title
        ]);
    }
}
