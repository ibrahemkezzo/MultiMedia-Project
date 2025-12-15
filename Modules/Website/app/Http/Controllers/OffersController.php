<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Website\Services\WebsiteService;

class OffersController extends Controller
{
    public function index(Request $request, WebsiteService $service)
    {
        $products = $service->getFilteredProducts($request, true); // true = offers only

        return view('website::website.offers', compact('products'));
    }
}
