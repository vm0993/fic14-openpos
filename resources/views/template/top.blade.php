<div class="top-bar-boxed h-[70px] md:h-[65px] z-[51] border-b border-white/[0.08] mt-2 md:mt-0 -mx-3 sm:-mx-8 md:-mx-0 px-3 md:border-b-0 relative md:fixed md:inset-x-0 md:top-0 sm:px-8 md:px-10 md:pt-10 md:bg-gradient-to-b md:from-slate-100 md:to-transparent dark:md:from-darkmode-700">
    <div class="h-full flex items-center">
        <a href="{{ route('dashboard') }}" class="logo -intro-x hidden md:flex xl:w-[150px] block">
            <img alt="myKedai" class="logo__image w-8" src="{{ asset('images/coffee.ico') }}">
            <span class="logo__text text-white text-lg ml-3 mr-2">{{ env('APP_NAME') }}</span>
        </a>
        <nav aria-label="breadcrumb" class="-intro-x h-[45px] mr-auto">
            <ol class="breadcrumb breadcrumb-light" style="margin-left: 1.7rem;">
                <?php $link = "" ?>
                @for($i = 1; $i <= count(Request::segments()); $i++)
                    @if($i < count(Request::segments()) & $i > 0)
                    <?php $link .= "/" . Request::segment($i); ?>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="javascript:;">{{ ucwords(str_replace('-',' ',Request::segment($i))) }}</a>
                    </li>
                    @else
                    <?php $link .= "/" . Request::segment($i); ?>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="javascript:;">{{ ucwords(str_replace('-',' ',Request::segment($i))) }}</a>
                    </li>
                    @endif
                @endfor
            </ol>
        </nav>
        <div class="intro-x relative mr-3 sm:mr-6">
            <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <div class="intro-x dropdown mr-4 sm:mr-6">
            <div class="dropdown-toggle notification notification--bullet cursor-pointer" role="button" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="bell" class="notification__icon dark:text-slate-500"></i> </div>
            <div class="notification-content pt-2 dropdown-menu">

            </div>
        </div>
        <div class="intro-x dropdown w-8 h-8">
            <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in scale-110" role="button" aria-expanded="false" data-tw-toggle="dropdown">
                <img alt="schERP" src="{{ asset('/images/default-avatar.png') }}">
            </div>
            <div class="dropdown-menu w-56">
                <ul class="dropdown-content bg-primary/80 before:block before:absolute before:bg-black before:inset-0 before:rounded-md before:z-[-1] text-white">
                    <li class="p-2">
                        <div class="font-medium">
                            @if(Auth::check())
                            {{ auth()->user()->name }}
                            @endif
                        </div>
                        <div class="text-xs text-white/70 mt-0.5 dark:text-slate-500"></div>
                        <div class="text-xs text-white/70 mt-0.5 dark:text-slate-300"></div>
                    </li>
                    <li>
                        <hr class="dropdown-divider border-white/[0.08]">
                    </li>
                    <li>
                        <a href="" class="dropdown-item hover:bg-white/5">
                        <i data-lucide="bell" class="w-4 h-4 mr-2"></i> Allow Notifycation
                        </a>
                    </li>
                    <li>
                        <a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="user" class="w-4 h-4 mr-2"></i> Profile </a>
                    </li>
                    <li>
                        <a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="lock" class="w-4 h-4 mr-2"></i> Ganti Password </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider border-white/[0.08]">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();this.closest('form').submit();"
                                class="dropdown-item hover:bg-white/5">
                                <i data-lucide="toggle-right" class="w-4 h-4 mr-2"></i>
                                Logout
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
