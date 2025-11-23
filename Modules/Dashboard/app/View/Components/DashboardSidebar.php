<?php

namespace Modules\Dashboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class DashboardSidebar extends Component
{
    public $sidebarItems;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->sidebarItems = config('dashboard.sidebar.items');
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('dashboard::components.dashboardsidebar',[
            'sidebarItems' => $this->sidebarItems,
            // 'user' => Auth::user(),
        ]);
    }
}
