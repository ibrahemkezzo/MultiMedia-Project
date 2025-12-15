<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Website\Services\WebsiteService;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, WebsiteService $service)
    {
        $products = $service->getFilteredProducts($request);

        return view('website::website.home', compact('products'));
    }
    
}
