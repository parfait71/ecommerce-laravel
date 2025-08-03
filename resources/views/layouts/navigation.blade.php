<nav x-data="{ open: false }" class="navbar-custom navbar-expand-lg">
    <div class="container">
        <div class="navbar-brand d-flex align-items-center">
            <a href="{{ Auth::check() && Auth::user()->is_admin ? route('admin.dashboard') : route('home') }}" class="text-white text-decoration-none">
                <i class="fas fa-store me-3 text-white"></i>
                <span class="fw-bold fs-3 text-white">EazyStore</span>
            </a>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link text-white px-3 py-2" href="{{ route('home') }}">
                        <i class="fas fa-home me-2"></i>Accueil
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link text-white px-3 py-2" href="{{ route('products.index') }}">
                        <i class="fas fa-shopping-bag me-2"></i>Catalogue
                    </a>
                </li>
                
                @auth
                    @if(!Auth::user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link text-white px-3 py-2" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart me-2"></i>Panier
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link text-white px-3 py-2" href="{{ route('orders.index') }}">
                                <i class="fas fa-list me-2"></i>Mes commandes
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav">
                @guest
                    <li class="nav-item">
                        <a class="nav-link text-white px-3 py-2" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i>Connexion
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white px-3 py-2" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-2"></i>Inscription
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white px-3 py-2" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user me-2"></i>Mon profil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('analytics.dashboard') }}">
                                    <i class="fas fa-chart-line me-2"></i>Mon tableau de bord
                                </a>
                            </li>
                            @if(Auth::user()->is_admin)
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>Administration
                                    </a>
                                </li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Se déconnecter
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
