<nav class="w-64 bg-blue-900 text-white min-h-screen p-6">
    <h1 class="text-2xl font-bold mb-8">Admin Panel</h1>
    
    <div class="space-y-4">
        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}" 
           class="block px-4 py-2 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
            Dashboard
        </a>

        {{-- Advertisements --}}
        @if(Auth::user()->role->canPerform('view', 'advertisements'))
            <div class="border-t border-blue-700 pt-4 mt-4">
                <h3 class="text-sm font-semibold text-blue-200 px-4 mb-2">Management</h3>
                <a href="{{ route('admin.advertisements.index') }}" 
                   class="block px-4 py-2 rounded {{ request()->routeIs('admin.advertisements.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                    Advertisements
                </a>
            </div>
        @endif

        {{-- Customers --}}
        @if(Auth::user()->role->canPerform('view', 'customers'))
            <a href="{{ route('admin.customers.index') }}" 
               class="block px-4 py-2 rounded {{ request()->routeIs('admin.customers.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                Customers
            </a>
        @endif

        {{-- Customer types --}}
        @if(Auth::user()->role->canPerform('view', 'customer_types'))
            <a href="{{ route('admin.customer_types.index') }}" 
               class="block px-4 py-2 rounded {{ request()->routeIs('admin.customer_types.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                Customer Types
            </a>
        @endif

        {{-- Customer categories --}}
        @if(Auth::user()->role->canPerform('view', 'customer_categories'))
            <a href="{{ route('admin.customer_categories.index') }}" 
               class="block px-4 py-2 rounded {{ request()->routeIs('admin.customer_categories.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                Customer Categories
            </a>
        @endif

        {{-- Partners --}}
        @if(Auth::user()->role->canPerform('view', 'partners'))
            <a href="{{ route('admin.partners.index') }}" 
               class="block px-4 py-2 rounded {{ request()->routeIs('admin.partners.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                Partners
            </a>
        @endif

        {{-- Transactions --}}
        @if(Auth::user()->role->canPerform('view', 'transactions'))
            <a href="{{ route('admin.transactions.index') }}" 
               class="block px-4 py-2 rounded {{ request()->routeIs('admin.transactions.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                Transactions
            </a>
        @endif

        {{-- Users --}}
        @if(Auth::user()->role->canPerform('view', 'users'))
            <a href="{{ route('admin.users.index') }}" 
               class="block px-4 py-2 rounded {{ request()->routeIs('admin.users.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                Users
            </a>
        @endif

        {{-- Payouts --}}
        @if(Auth::user()->role->canPerform('view', 'payouts'))
            <a href="{{ route('admin.payouts.index') }}" 
               class="block px-4 py-2 rounded {{ request()->routeIs('admin.payouts.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                Payouts
            </a>
        @endif

        {{-- Enrollments --}}
        @if(Auth::user()->role->canPerform('view', 'enrollments'))
            <a href="{{ route('admin.enrollments.index') }}" 
               class="block px-4 py-2 rounded {{ request()->routeIs('admin.enrollments.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                Enrollments
            </a>
        @endif

        {{-- Reports --}}
        @if(Auth::user()->role->canPerform('view', 'reports'))
            <a href="{{ route('admin.reports.index') }}" 
               class="block px-4 py-2 rounded {{ request()->routeIs('admin.reports.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                Reports
            </a>
        @endif

        {{-- Master Data --}}
        @if(Auth::user()->role->canPerform('view', 'masterdata'))
            <div class="border-t border-blue-700 pt-4 mt-4">
                <h3 class="text-sm font-semibold text-blue-200 px-4 mb-2">Master Data</h3>
                <a href="{{ route('admin.provinces.index') }}" 
                   class="block px-4 py-2 rounded {{ request()->routeIs('admin.provinces.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                    Provinces
                </a>
                <a href="{{ route('admin.cities.index') }}" 
                   class="block px-4 py-2 rounded {{ request()->routeIs('admin.cities.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                    Cities
                </a>
                <a href="{{ route('admin.districts.index') }}" 
                   class="block px-4 py-2 rounded {{ request()->routeIs('admin.districts.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                    Districts
                </a>
                <a href="{{ route('admin.subdistricts.index') }}" 
                   class="block px-4 py-2 rounded {{ request()->routeIs('admin.subdistricts.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                    Subdistricts
                </a>
                <a href="{{ route('admin.vehicle-brands.index') }}" 
                   class="block px-4 py-2 rounded {{ request()->routeIs('admin.vehicle-brands.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                    Vehicle Brands
                </a>
                <a href="{{ route('admin.banks.index') }}" 
                   class="block px-4 py-2 rounded {{ request()->routeIs('admin.banks.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                    Banks
                </a>
            </div>
        @endif
    </div>
</nav>
