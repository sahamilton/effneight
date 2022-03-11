    <header class="bg-gray-700 text-white p-2" x-data="{ open: false }">
      <div class="flex justify-between items-center">
        <h1 class="font-bold tracking-widest uppercase">
           <a href="">{{config('app.name')}}</a>
        </h1>
        {{-- Desktop Nav Menu --}}
        @auth
        <x-mainnav />

        {{-- Mobile Menu Toggle Buttons --}}
        <div class="md:hidden">
            <button @click="open = ! open">
                {{-- Hamburger Icon --}}
                <svg x-show="! open" viewBox="0 0 20 20" width="20">
                    <g stroke="none"
                       stroke-width="1"
                       fill="none"
                       fill-rule="evenodd"
                    >
                        <g fill="white">
                            <path d="M0,3 L20,3 L20,5 L0,5 L0,3 Z M0,9 L20,9 L20,11 L0,11 L0,9 Z M0,15 L20,15 L20,17 L0,17 L0,15 Z"></path>
                        </g>
                    </g>
                </svg>

                {{-- Close Icon --}}
                <svg x-show="open" viewBox="0 0 20 20" width="20">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g fill="white">
                            <polygon id="Combined-Shape" points="10 8.58578644 2.92893219 1.51471863 1.51471863 2.92893219 8.58578644 10 1.51471863 17.0710678 2.92893219 18.4852814 10 11.4142136 17.0710678 18.4852814 18.4852814 17.0710678 11.4142136 10 18.4852814 2.92893219 17.0710678 1.51471863 10 8.58578644"></polygon>
                        </g>
                    </g>
                </svg>
            </button>
        </div>

        {{-- User Avatar and Dropdown Menu --}}
        <div class="hidden md:block">
            <x-dropdown alignment="right">
                <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
            </x-dropdown>
        </div>
    </div>

    <!-- Mobile Nav Menu -->
    <nav x-show="open" class="mt-3">
        
        <x-mobile-nav-link route="clients.index">Clients</x-mobile-nav-link>
        <x-mobile-nav-link route="activities.index">Activities</x-mobile-nav-link>
        <x-mobile-nav-link route="invoices.index">Invoices</x-mobile-nav-link>
        <x-mobile-nav-link route="payments.index">Payments</x-mobile-nav-link>
        <x-mobile-nav-link route="recordtime">Time Tracking</x-mobile-nav-link>
    </nav>
    @endauth
  </header>