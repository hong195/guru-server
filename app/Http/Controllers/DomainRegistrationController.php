<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;

class DomainRegistrationController extends Controller
{
    public function createRequest(Request $request)
    {
        Domain::where();
    }

    public function register(Request $request)
    {
        Domain::approve($request->get('code'));

        return response()->json();
    }


    public function deregister()
    {

    }
}
