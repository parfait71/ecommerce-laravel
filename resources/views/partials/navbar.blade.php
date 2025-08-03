<nav class="bg-white border-b border-gray-200 px-4 py-2 flex items-center justify-between">
    <a href="{{ route('home') }}" class="font-bold text-lg text-indigo-600">EazyStore</a>
    <ul class="flex space-x-4">
        <li><a href="{{ route('home') }}" class="hover:underline">Accueil</a></li>
        <li>
            @if(Auth::check() && Auth::user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" class="hover:underline">Tableau de bord</a>
            @else
                <a href="{{ route('dashboard') }}" class="hover:underline">Tableau de bord</a>
            @endif
        </li>
        <li><a href="{{ route('products.index') }}" class="hover:underline">Catalogue</a></li>
    </ul>
</nav>
