<style>
     .dropdown{
        color:#a5a59d;
     }
    .dropdown:hover{
        background-color:#edefca;


    }
    nav{
        background-color:#bfb771;
    }
    .guest{
        color:rgb(119, 119, 113);
    }
</style>

<nav x-data="{ open: false }" class="bg-gradient-to-r text-white shadow-lg">
    <!-- Primary Navigation Menu -->
     
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/home') }}">
                        <x-application-logo class="block w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="url('/')" :active="request()->is('/')">
                        {{ __('Home') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="url('shop')" :active="request()->is('shop')">
                        {{ __('Shop All') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="url('about-us')" :active="request()->is('about-us')">
                        {{ __('About Us') }}
                    </x-nav-link>
                </div>
                @auth
                @if(Auth::user()->type!='user')
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="url('dashboard')" :active="request()->is('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
                @endif
                @endauth
            </div>

          <!-- Settings Dropdown -->
@guest
    @if (Route::has('login'))
        <div class='hidden space-x-8 sm:-my-px sm:ms-10 sm:flex' style="margin-top:25px;margin-left:20px">
            <a href="{{ url('tenantlogin') }}" class="guest font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white" >Log in</a>
            
            @if (Route::has('register'))
                <a href="{{ url('tenantregister') }}" class="guest ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Register</a>
            @endif
        </div>
    @endif
@else
    <div class="hidden sm:flex sm:items-center sm:ms-6">
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="flex items-center  text-white px-4 py-2 rounded-lg font-medium shadow-lg  transition" >
                <i class="fa-solid fa-user" style="color:#5c5c58;margin-right:10px "></i>
                <div style="color:#5c5c58">{{ Auth::user()->name }}</div>
                <svg class="ml-2 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color:#5c5c58">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')" class="dropdown">
                    {{ __('Profile') }}
                </x-dropdown-link>

                <!-- Authentication -->
                <form method="POST" action="{{ url('tenantlogout') }}">
                            @csrf

                            <x-dropdown-link :href="url('tenantlogout')" class="dropdown"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
            </x-slot>
        </x-dropdown>
    </div>
@endguest


            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="url('home')" :active="request()->is('home')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

    
        <!-- Responsive Settings Options -->
        @guest
        <div class="pt-2 pb-3 space-y-1">
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                    Log in
                </a>
            @endif

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                    Register
                </a>
            @endif
        </div>
    @else
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    @endguest
    </div>
</nav>
