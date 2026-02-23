@auth
<nav class="flex-1 px-4 pt-2 space-y-1 text-sm">
    @if (auth()->user()->role->menus() && in_array('my-dashboard', auth()->user()->role->menus()))
            {{-- Dashboard --}}
            <a href="{{ route('my-dashboard') }}"
               class="sidebar-link {{ request()->routeIs('my-dashboard') ? 'active' : '' }}">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>
    @endif

    @if (auth()->user()->role->menus() && in_array('my-ads', auth()->user()->role->menus()))
            {{-- Iklan --}}
            <a href="{{ route('my-ads.index') }}"
               class="sidebar-link {{ request()->routeIs('my-ads.*') ? 'active' : '' }}">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M11 5.882V19.236a.5.5 0 01-.766.424L5.556 16H4a2 2 0 01-2-2V10a2 2 0 012-2h1.556l4.678-3.542a.5.5 0 01.766.424z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M15 8l2-2m0 10l-2-2m2-4l3 1m-3 2l3-1" />
                </svg>
                Iklan
            </a>
    @endif

    @if (auth()->user()->role->menus() && in_array('my-orders', auth()->user()->role->menus()))
            {{-- Monitoring --}}
            <a href="{{ route('my-monitoring.index') }}"
               class="sidebar-link {{ request()->routeIs('my-monitoring.*') ? 'active' : '' }}">
                <svg class="icon" fill="none" viewBox="0 0 24 24">
                    <path stroke-width="2" d="M4 19h16M4 15l4-4 4 4 4-6 4 6"/>
                </svg>
                Monitoring
            </a>
    @endif

    @if (auth()->user()->role->menus() && in_array('my-payment', auth()->user()->role->menus()))
            {{-- Pembayaran --}}
            <a href="{{ route('my-payment.index') }}"
               class="sidebar-link {{ request()->routeIs('my-payment.*') ? 'active' : '' }}">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Pembayaran
            </a>
    @endif

    @if (auth()->user()->role->menus() && in_array('my-profile', auth()->user()->role->menus()))
            {{-- Profile Customer --}}
            <a href="{{ route('my-profile.index') }}"
               class="sidebar-link {{ request()->routeIs('my-profile.*') ? 'active' : '' }}">
                <svg class="icon" fill="none" viewBox="0 0 24 24">
                    <path stroke-width="2" d="M12 12a5 5 0 100-10 5 5 0 000 10zM4 22a8 8 0 0116 0"/>
                </svg>
                Profile
            </a>
    @endif
</nav>
@endauth