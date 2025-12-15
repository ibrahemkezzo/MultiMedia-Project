<?php

namespace Modules\Website\View\Components\Layouts;

use Illuminate\View\Component;
use Illuminate\View\View;

class MobileMapWebsite extends Component
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
        return view('website::components.layouts/mobilemapwebsite');
    }
}
