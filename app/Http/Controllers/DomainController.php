<?php

namespace App\Http\Controllers;

use App\Http\Requests\DomainRequest;
use App\Services\Domain\DomainService;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function __construct(private DomainService $domainService){
    }

    public function activate(DomainRequest $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|string|\Illuminate\Contracts\Foundation\Application
    {
        $goBackUrl = $request->getDTO()->getUrl() . '/wp-admin/admin.php?page=bftow_settings';

        try {
            $this->domainService->activate($request);
            $title = 'Plugin was successfully activated';
        }catch (\Exception $e) {
            $title = 'Activation error, please try later';
        }

        return view('activation-success', [
            'description' => '<a href='. $goBackUrl .'>Go back to the amdin panel</a>',
            'title' => $title
        ]);
    }

    public function deActivate(DomainRequest $request): string
    {
        $goBackUrl = $request->getDTO()->getUrl() . '/wp-admin/admin.php?page=bftow_settings';

        try {
            $this->domainService->deActivate($request);
            $title = 'Plugin was successfully disconnected to ' . $request->getDTO()->getUrl() .' domain';
        }catch (\Exception $e) {
            $title = 'Error occurred, please try later';
        }

        return view('activation-success', [
            'description' => '<a href='. $goBackUrl .'>Go back to the amdin panel</a>',
            'title' => $title
        ]);
    }
}
