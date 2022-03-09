<?php

namespace App\Http\Controllers;

use App\Http\Requests\DomainRequest;
use App\Services\Domain\DomainService;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function __construct(private DomainService $domainService){
    }

    public function request(DomainRequest $request)
    {
        try {
            return $this->domainService->request($request);
        }catch (\Exception $e) {
            throw $e;
        }
    }

    public function activate(DomainRequest $request)
    {
        try {
            $this->domainService->register($request);
            return 'success';
        }catch (\Exception $e) {
            throw $e;
        }
    }

    public function deActivate(Request $request)
    {
        try {
            $this->domainService->register($request);
            return 'success';
        }catch (\Exception $e) {
            throw $e;
        }
    }
}
