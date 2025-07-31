<nav class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="w-full flex flex-col items-center py-2 animate-fade-in-up">
            <!-- Logo centré -->
            <div class="mb-2 animate-slide-in-left w-full flex justify-center">
                <a href="{{ Auth::check() && Auth::user()->is_admin ? route('admin.dashboard') : route('home') }}">
                    <img src="/images/mon_logo.png"
                         alt="Logo"
                         class="mb-2 animate-slide-in-left mx-auto logo-responsive"
                         style="max-width: 120px; width: 100%; height: auto;">
                </a>
            </div>
            <!-- Menu horizontal centré et responsive -->
            <div class="flex flex-wrap justify-center space-x-4 sm:space-x-8 mt-2 animate-fade-in-up" style="animation-delay: 0.2s;">
                <a href="{{ url('/') }}" class="btn btn-primary px-4 py-2 fw-bold mx-1">Accueil</a>
                <a href="{{ url('/catalogue') }}" class="btn btn-primary px-4 py-2 fw-bold mx-1">Catalogue</a>
                @auth
                    @if(Auth::user()->is_admin)
                        <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary px-4 py-2 fw-bold mx-1">Dashboard</a>
                    @else
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary px-4 py-2 fw-bold mx-1">Dashboard</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>
