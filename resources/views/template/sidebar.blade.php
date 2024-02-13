@if(Auth::check())
<nav class="side-nav">
    <ul>
        <li>
            <a href="{{ route('dashboard') }}" style="padding-left: 1rem;" class="side-menu {{ request()->segment(1) == 'dashboard' ? 'side-menu--active' : '' }} ">
                <div class="side-menu__icon">
                    <i data-lucide="home"></i>
                </div>
                <div class="side-menu__title">
                    Dashboard
                    <div class="side-menu__sub-icon transform rotate-180"> </div>
                </div>
            </a>
        </li>
        <li class="side-nav__devider my-2"></li>
        <li>
            <a href="{{ route('reports.index') }}" style="padding-left: 1rem;" class="side-menu {{ request()->segment(1) == 'reports' ? 'side-menu--active' : '' }} ">
                <div class="side-menu__icon">
                    <i data-lucide="printer"></i>
                </div>
                <div class="side-menu__title">
                    Reports
                    <div class="side-menu__sub-icon transform rotate-180"> </div>
                </div>
            </a>
        </li>
        <li>
            <a href="javascript:;" style="padding-left: 1rem;" class="side-menu {{ request()->segment(1) == 'outlets' ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">
                    <i data-lucide="layers"></i>
                </div>
                <div class="side-menu__title">
                    Outlets
                    <i data-lucide="chevron-down" class="side-menu__sub-icon"></i>
                </div>
            </a>
            <ul>
                @can('view', \App\Models\Master\Outlet::class)
                <li>
                    <a href="{{ route('outlets.outlet.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-lucide="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Outlet
                        </div>
                    </a>
                </li>
                @endcan

                {{-- @can('view', \App\Models\Master\Employee::class) --}}
                <li>
                    <a href="{{ route('outlets.employee.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-lucide="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Employee
                        </div>
                    </a>
                </li>
                {{-- @endcan

                @can('view', \App\Models\Master\Promo::class) --}}
                <li>
                    <a href="{{ route('outlets.promo.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-lucide="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Promo
                        </div>
                    </a>
                </li>
                {{-- @endcan --}}
            </ul>
        </li>
        <li>
            <a href="javascript:;" style="padding-left: 1rem;" class="side-menu {{ request()->segment(1) == 'masters' ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">
                    <i data-lucide="box"></i>
                </div>
                <div class="side-menu__title">
                    Master
                    <i data-lucide="chevron-down" class="side-menu__sub-icon"></i>
                </div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('masters.category.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-lucide="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Category
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('masters.unit.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-lucide="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Unit
                        </div>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('masters.tax.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-lucide="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Tax
                        </div>
                    </a>
                </li> --}}
                <li>
                    <a href="{{ route('masters.item.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-lucide="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Item
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('masters.ingradiant.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-lucide="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Ingradiants
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('masters.customer.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-lucide="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Customer
                        </div>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" style="padding-left: 1rem;" class="side-menu {{ request()->segment(1) == 'inventorys' ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">
                    <i data-lucide="package"></i>
                </div>
                <div class="side-menu__title">
                    Inventory
                    <i data-lucide="chevron-down" class="side-menu__sub-icon"></i>
                </div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('inventorys.item-incoming.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-lucide="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Item In
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('inventorys.item-opname.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-lucide="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Item Opname
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('inventorys.item-adjustment.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-lucide="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Item Adjustment
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('inventorys.stock-monitoring.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-lucide="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Stock Monitoring
                        </div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="side-nav__devider my-2"></li>
        <li>
            <a href="javascript:;" style="padding-left: 1rem;" class="side-menu {{ request()->segment(1) == 'settings' ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">
                    <i data-lucide="settings"></i>
                </div>
                <div class="side-menu__title">
                    Setting
                    <i data-lucide="chevron-down" class="side-menu__sub-icon"></i>
                </div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('settings.company.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-lucide="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Company
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('settings.group-permissions.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-lucide="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Permission
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('settings.user.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-lucide="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            User
                        </div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
@endif
