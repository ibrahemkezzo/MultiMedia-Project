<?php

namespace Modules\Website\View\Components\Layouts;

use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\Category\Models\Category;

class FilterWebsite extends Component
{
    /**
     * Create a new component instance.
     */
    public $display;
    public function __construct($display = 'd-block') {
        $this->display = $display;
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        $categories = Category::main()->active()->get();
        $subcategories = Category::child()->active()->get();

        return view('website::components.layouts.filterwebsite', compact('categories', 'subcategories'));}
}
