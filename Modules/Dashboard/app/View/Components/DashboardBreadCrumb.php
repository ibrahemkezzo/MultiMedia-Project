<?php

namespace Modules\Dashboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class DashboardBreadCrumb extends Component
{

    public $breadcrumbs;

    public $pageName;
    /**
     * Create a new component instance.
     */
    public function __construct(array $breadcrumbs = [], string $pageName = '')
    {
        $this->breadcrumbs = $breadcrumbs;

        $this->pageName = $pageName;

    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('dashboard::components.dashboardbreadcrumb');
    }
}
