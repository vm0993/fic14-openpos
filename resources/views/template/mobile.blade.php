<!-- BEGIN: Mobile Menu -->
<div class="mobile-menu md:hidden pt-2 -mt-2">
    <div class="mobile-menu-bar">
        <a href="{{ route('dashboard') }}" class="flex mr-auto">
            <img alt="myKedai" class="w-8" src="{{ asset('images/coffee.ico') }}">
        </a>
        <a href="javascript:;" id="mobile-menu-toggler">
            <i data-lucide="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i>
        </a>
    </div>
    <ul class="border-t border-theme-29 py-2 hidden">
        <li>
            <a href="{{ route('dashboard') }}" class="menu">
                <div class="menu__icon">
                    <i data-lucide="home"></i>
                </div>
                <div class="menu__title">
                    Dashboard
                </div>
            </a>
        </li>
    </ul>
</div>
