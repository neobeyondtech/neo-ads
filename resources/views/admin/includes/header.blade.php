<header class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
    <h2 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Admin')</h2>
    
    <div class="flex items-center gap-4">
        <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-sm text-blue-600 hover:text-blue-800">Logout</button>
        </form>
    </div>
</header>
