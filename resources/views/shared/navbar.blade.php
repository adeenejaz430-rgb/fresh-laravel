            @php
                use Illuminate\Support\Facades\Route;

                $user      = auth()->user();
                $isAuthed  = (bool) $user;
                $current   = url()->current();

                $navLinks = [
                    ['name' => 'Home',     'route' => 'shop.home',      'href' => '/'],
                    ['name' => 'Products', 'route' => 'products.index', 'href' => '/products'],
                    ['name' => 'About',    'route' => null,             'href' => '/about'],
        ['name' => 'Blog',     'route' => 'blog.index',     'href' => '/blog'],
        ['name' => 'Contact',  'route' => 'contact.index',  'href' => '/contact'],
                ];

                $categoriesList = $categories ?? [];
                $cartCount      = $cartCount ?? 0;
                $wishlistCount  = $wishlistCount ?? 0;
            @endphp

<header class="fixed top-0 left-0 right-0 w-full z-50 bg-white border-b border-gray-200 shadow-sm" style="height: 80px;">
    <div class="container mx-auto px-4 lg:px-8 h-full">
        <div class="flex items-center justify-between h-full">
            
            {{-- LEFT: Logo --}}
            <div class="flex items-center">
                <a href="{{ route('shop.home') }}" class="flex items-center">
                    <div class="relative h-12 w-auto">
                        <img src="/logo.png" alt="Logo" class="h-full w-auto object-contain">
                    </div>
                </a>
            </div>

            {{-- CENTER/RIGHT: Menu Items + Search + Icons --}}
            <div class="flex items-center gap-6">
                {{-- DESKTOP NAV MENU --}}
                <nav class="hidden lg:flex items-center gap-6">
                @foreach($navLinks as $link)
                    @php
                        $href = (!empty($link['route']) && Route::has($link['route']))
                                    ? route($link['route'])
                                    : url($link['href']);
                        $active = ($current === $href);
                    @endphp

                    <a href="{{ $href }}"
                           class="text-base font-semibold text-gray-700 hover:text-gray-900 transition-colors relative pb-1 group
                                  {{ $active ? 'text-gray-900' : '' }}">
                        {{ $link['name'] }}
                            @if($active)
                                <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-gray-900"></span>
                            @else
                                <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-gray-900 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                            @endif
                    </a>
                @endforeach

                {{-- CATEGORIES DROPDOWN --}}
                @if(count($categoriesList))
                    <div class="relative" id="categoriesDropdown">
                            <button class="text-base font-semibold text-gray-700 hover:text-gray-900 transition-colors flex items-center gap-1 group relative pb-1">
                            Categories
                                <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                                <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-gray-900 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                        </button>

                        <div
                                class="absolute left-0 mt-2 w-56 bg-white shadow-lg rounded-md 
                                       transition-all duration-200 border border-gray-100 z-50 hidden
                                   transform origin-top scale-95 opacity-0"
                            id="categoriesMenu"
                                style="transition: opacity 0.2s, transform 0.2s;"
                        >
                            <div class="py-2">
                                @foreach($categoriesList as $cat)
                                    @php
                                        $slug = $cat->slug ?? $cat['slug'];
                                            $categoryHref = Route::has('categories.show')
                                                ? route('categories.show', $slug)
                                            : '#';
                                    @endphp

                                    <a href="{{ $categoryHref }}"
                                           class="block px-4 py-2.5 text-sm text-gray-700 
                                                  hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                        {{ $cat->name ?? $cat['name'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

            </nav>

                {{-- RIGHT SIDE: Search Icon + Inline Search + Icons --}}
                <div class="flex items-center gap-3">
                    {{-- SEARCH ICON & INLINE SEARCH FORM --}}
                    <div class="relative flex items-center" id="searchContainer">
                        <button 
                            type="button"
                            id="searchToggleBtn"
                            class="w-9 h-9 flex items-center justify-center text-gray-600 hover:text-gray-900 transition-colors"
                            aria-label="Search"
                        >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        </button>
                        
                        {{-- INLINE SEARCH FORM --}}
                        <form 
                            method="GET" 
                            action="{{ route('search') }}"
                            id="navbarSearchForm"
                            class="hidden flex items-center gap-0 bg-white border border-gray-300 rounded-md shadow-sm"
                            style="width: 260px;"
                        >
                            <input
                                type="text"
                                name="q"
                                id="navbarSearchInput"
                                placeholder="Search products..."
                                value="{{ request('q') }}"
                                class="flex-1 px-3 py-2 text-sm text-gray-700 bg-white focus:outline-none focus:border-gray-400 rounded-l-md"
                                autocomplete="off"
                                style="height: 36px;"
                            />
                            <button
                                type="submit"
                                class="px-3 py-2 bg-gray-700 text-white text-sm font-medium rounded-r-md hover:bg-gray-800 transition-colors whitespace-nowrap"
                                style="height: 36px;"
                            >
                                Search
                    </button>
                </form>
                    </div>

                {{-- RIGHT ICONS: Cart, Wishlist, User --}}
                {{-- WISHLIST --}}
                @if($isAuthed)
                    <a href="{{ route('wishlist.index') }}"
                           class="relative w-9 h-9 flex items-center justify-center text-gray-600 hover:text-gray-900 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        @if($wishlistCount > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold
                                             rounded-full h-5 w-5 flex items-center justify-center">
                                {{ $wishlistCount }}
                            </span>
                        @endif
                    </a>
                @endif

                {{-- CART --}}
                @if($isAuthed)
                        <button onclick="openCartSidebar()"
                           class="relative w-9 h-9 flex items-center justify-center text-gray-600 hover:text-gray-900 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        @if($cartCount > 0)
                                <span id="navbarCartCount" class="cart-count-badge absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold
                                             rounded-full h-5 w-5 flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                            @else
                                <span id="navbarCartCount" class="cart-count-badge absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold
                                             rounded-full h-5 w-5 flex items-center justify-center hidden">
                                    0
                        </span>
                            @endif
                        </button>
                @endif

                {{-- USER DROPDOWN --}}
                @if($isAuthed)
                        <div class="relative" id="userDropdown">
                            <button class="w-9 h-9 flex items-center justify-center text-gray-600 hover:text-gray-900 transition-colors" id="userButton">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            </button>

                        <div
                                class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-100
                                       transition-all duration-200 py-2 z-50 hidden
                                   transform origin-top-right scale-95 opacity-0"
                            id="userMenu"
                                style="transition: opacity 0.2s, transform 0.2s;"
                            >
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                            </div>

                            <div class="py-2">
                                <a href="{{ route('profile.index') }}"
                                       class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <span>My Profile</span>
                                    </a>
                                <a href="{{ route('orders.index') }}"
                                       class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <span>My Orders</span>
                                    </a>
                                <a href="{{ route('wishlist.index') }}"
                                       class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <span>Wishlist</span>
                                    @if($wishlistCount > 0)
                                            <span class="bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                            {{ $wishlistCount }}
                                        </span>
                                    @endif
                                </a>
                                @if(isset($user->role) && $user->role === 'admin' && Route::has('admin.dashboard'))
                                    <a href="{{ route('admin.dashboard') }}"
                                           class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                            <span>Admin Dashboard</span>
                                    </a>
                                @endif
                            </div>

                            <div class="border-t border-gray-100 mt-2 pt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                        <button type="submit"
                                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                            Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                        <a href="{{ route('login') }}" class="w-9 h-9 flex items-center justify-center text-gray-600 hover:text-gray-900 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                    </a>
                @endif

                {{-- MOBILE MENU BUTTON --}}
                <button
                        class="lg:hidden w-9 h-9 flex items-center justify-center text-gray-600 hover:text-gray-900 transition-colors"
                    id="mobileMenuButton"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
            </div>
        </div>
    </div>
</header>

{{-- MOBILE MENU OVERLAY --}}
<div id="mobileMenuOverlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden backdrop-blur-sm hidden opacity-0 transition-opacity duration-300"></div>

{{-- MOBILE SLIDING MENU --}}
<div id="mobileMenu" 
     class="fixed top-0 left-0 h-full w-80 bg-white shadow-2xl z-50 lg:hidden overflow-y-auto transform -translate-x-full transition-transform duration-300">
    
    <div class="p-6 pt-24">
        <div class="space-y-1">
                @foreach($navLinks as $link)
                    @php
                        $href = (!empty($link['route']) && Route::has($link['route']))
                                    ? route($link['route'])
                                    : url($link['href']);
                        $active = ($current === $href);
                    @endphp

                    <a href="{{ $href }}"
                   class="block px-4 py-3 text-base font-semibold text-gray-700 hover:bg-gray-50 rounded-lg
                          {{ $active ? 'bg-gray-100 text-gray-900' : '' }}">
                        {{ $link['name'] }}
                    </a>
                @endforeach

                @if(count($categoriesList))
                <div class="pt-4 border-t border-gray-200 mt-4">
                    <p class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Categories</p>
                                @foreach($categoriesList as $cat)
                                    @php
                                        $slug = $cat->slug ?? $cat['slug'];
                            $categoryHref = Route::has('categories.show') ? route('categories.show', $slug) : '#';
                                    @endphp
                                    <a href="{{ $categoryHref }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">
                                        {{ $cat->name ?? $cat['name'] }}
                                    </a>
                                @endforeach
                    </div>
                @endif

            {{-- SEARCH IN MOBILE MENU --}}
            <div class="pt-4 border-t border-gray-200 mt-4">
                <form method="GET" action="{{ route('search') }}" class="px-4">
                    <div class="flex gap-2">
                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                           placeholder="Search products..."
                            class="flex-1 px-4 py-3 text-base text-gray-700 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-green-500"
                        />
                                    <button
                                        type="submit"
                            class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors"
                                    >
                            Search
                                    </button>
                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // User Dropdown
    const userDropdown = document.getElementById('userDropdown');
    const userButton = document.getElementById('userButton');
    const userMenu = document.getElementById('userMenu');

    if (userDropdown && userButton && userMenu) {
        let userTimeout;

        userDropdown.addEventListener('mouseenter', function() {
            clearTimeout(userTimeout);
            userMenu.classList.remove('hidden');
            setTimeout(() => {
                userMenu.style.opacity = '1';
                userMenu.style.transform = 'scale(1)';
            }, 10);
        });

        userDropdown.addEventListener('mouseleave', function() {
            userTimeout = setTimeout(function() {
                userMenu.style.opacity = '0';
                userMenu.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    userMenu.classList.add('hidden');
                }, 200);
            }, 200);
        });

        userButton.addEventListener('click', function(e) {
            e.stopPropagation();
            const isHidden = userMenu.classList.contains('hidden');
            
            if (isHidden) {
                userMenu.classList.remove('hidden');
                setTimeout(() => {
                    userMenu.style.opacity = '1';
                    userMenu.style.transform = 'scale(1)';
                }, 10);
            } else {
                userMenu.style.opacity = '0';
                userMenu.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    userMenu.classList.add('hidden');
                }, 200);
            }
        });
    }

    // Categories Dropdown
    const categoriesDropdown = document.getElementById('categoriesDropdown');
    const categoriesMenu = document.getElementById('categoriesMenu');

    if (categoriesDropdown && categoriesMenu) {
        let catTimeout;

        categoriesDropdown.addEventListener('mouseenter', function() {
            clearTimeout(catTimeout);
            categoriesMenu.classList.remove('hidden');
            setTimeout(() => {
                categoriesMenu.style.opacity = '1';
                categoriesMenu.style.transform = 'scale(1)';
            }, 10);
        });

        categoriesDropdown.addEventListener('mouseleave', function() {
            catTimeout = setTimeout(function() {
                categoriesMenu.style.opacity = '0';
                categoriesMenu.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    categoriesMenu.classList.add('hidden');
                }, 200);
            }, 200);
        });
    }

    // Close dropdowns on outside click
    document.addEventListener('click', function(e) {
        if (userMenu && userDropdown && !userDropdown.contains(e.target)) {
            userMenu.style.opacity = '0';
            userMenu.style.transform = 'scale(0.95)';
            setTimeout(() => {
                userMenu.classList.add('hidden');
            }, 200);
        }
        if (categoriesMenu && categoriesDropdown && !categoriesDropdown.contains(e.target)) {
            categoriesMenu.style.opacity = '0';
            categoriesMenu.style.transform = 'scale(0.95)';
            setTimeout(() => {
                categoriesMenu.classList.add('hidden');
            }, 200);
        }
    });

    // Mobile Menu
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');

    if (mobileMenuButton && mobileMenu && mobileMenuOverlay) {
    function openMobileMenu() {
        mobileMenu.classList.remove('-translate-x-full');
        mobileMenuOverlay.classList.remove('hidden');
        setTimeout(() => {
            mobileMenuOverlay.classList.remove('opacity-0');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeMobileMenu() {
        mobileMenu.classList.add('-translate-x-full');
        mobileMenuOverlay.classList.add('opacity-0');
        setTimeout(() => {
            mobileMenuOverlay.classList.add('hidden');
        }, 300);
        document.body.style.overflow = '';
    }

    mobileMenuButton.addEventListener('click', function() {
        if (mobileMenu.classList.contains('-translate-x-full')) {
            openMobileMenu();
        } else {
            closeMobileMenu();
        }
    });

    mobileMenuOverlay.addEventListener('click', closeMobileMenu);
    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', closeMobileMenu);
    });
    }

    // Navbar Inline Search Toggle
    const searchToggleBtn = document.getElementById('searchToggleBtn');
    const navbarSearchForm = document.getElementById('navbarSearchForm');
    const navbarSearchInput = document.getElementById('navbarSearchInput');
    const searchContainer = document.getElementById('searchContainer');

    if (searchToggleBtn && navbarSearchForm && navbarSearchInput && searchContainer) {
        function toggleSearchForm() {
            const isHidden = navbarSearchForm.classList.contains('hidden');
            
            if (isHidden) {
                navbarSearchForm.classList.remove('hidden');
                // Focus input after a brief delay to ensure it's visible
                setTimeout(() => {
                    navbarSearchInput.focus();
                }, 10);
            } else {
                navbarSearchForm.classList.add('hidden');
                navbarSearchInput.blur();
            }
        }

        // Toggle on search icon click
        searchToggleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleSearchForm();
        });

        // Close when clicking outside (but not on the form itself)
        document.addEventListener('click', function(e) {
            if (searchContainer && !searchContainer.contains(e.target)) {
                if (!navbarSearchForm.contains(e.target)) {
                    navbarSearchForm.classList.add('hidden');
                }
            }
        });

        // Prevent form from closing when clicking inside it
        navbarSearchForm.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !navbarSearchForm.classList.contains('hidden')) {
                navbarSearchForm.classList.add('hidden');
                navbarSearchInput.blur();
            }
        });
    }
});
</script>
