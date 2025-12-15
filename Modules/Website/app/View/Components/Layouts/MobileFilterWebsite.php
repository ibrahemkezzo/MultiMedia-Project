<?php

namespace Modules\Website\View\Components\Layouts;

use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\Category\Models\Category;

class MobileFilterWebsite extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct() {}

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        $categories = Category::main()->active()->get();
        $subcategories = Category::child()->active()->get();

        return view('website::components.layouts/mobilefilterwebsite', compact('categories', 'subcategories'));
    }
}
