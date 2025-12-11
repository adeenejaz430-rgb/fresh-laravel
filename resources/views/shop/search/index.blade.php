@extends('layouts.store')

@section('title', 'Search Results')

@section('content')
<div class="bg-gradient-to-br from-slate-50 via-white to-slate-50 min-h-screen">
    {{-- HERO SECTION --}}
    <div class="relative bg-gradient-to-br from-green-600 via-emerald-600 to-teal-700 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 py-20 md:py-28 relative z-10">
            <div class="text-center text-white">
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-5 py-2.5 rounded-full mb-6 border border-white/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span class="text-sm font-semibold">Search Results</span>
                </div>

                <h1 class="text-5xl md:text-6xl lg:text-7xl font-black mb-6 leading-tight">
                    @if($query)
                        Results for
                        <span class="block bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">
                            "{{ $query }}"
                        </span>
                    @else
                        <span class="block bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">
                            Search Products
                        </span>
                    @endif
                </h1>

                <p class="text-xl md:text-2xl text-green-50 mb-8 leading-relaxed max-w-2xl mx-auto">
                    @if($query)
                        Found {{ $products->total() }} {{ Str::plural('result', $products->total()) }} for your search
                    @else
                        Enter a search term to find products
                    @endif
                </p>

                {{-- SEARCH FORM --}}
                <form method="GET" action="{{ route('search') }}" class="max-w-2xl mx-auto">
                    <div class="flex gap-3">
                        <input
                            type="text"
                            name="q"
                            value="{{ $query }}"
                            placeholder="Search for products..."
                            class="flex-1 px-6 py-4 rounded-2xl text-gray-800 text-lg focus:outline-none focus:ring-4 focus:ring-white/50 shadow-xl"
                        />
                        <button
                            type="submit"
                            class="px-8 py-4 bg-white text-green-600 font-bold rounded-2xl hover:bg-gray-100 transition-all shadow-xl hover:scale-105"
                        >
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="container mx-auto px-4 py-16">
        @if(!$query)
            {{-- NO SEARCH QUERY --}}
            <div class="text-center py-20 bg-white rounded-3xl shadow-xl border-2 border-gray-100">
                <div class="w-24 h-24 mx-auto bg-gradient-to-br from-green-100 to-emerald-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Start Your Search</h2>
                <p class="text-gray-600 mb-8 text-lg max-w-md mx-auto">
                    Use the search bar above to find products by name or description.
                </p>
                <a href="{{ route('products.index') }}">
                    <button class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-4 rounded-2xl hover:shadow-lg transition-all font-semibold">
                        Browse All Products
                    </button>
                </a>
            </div>
        @elseif($products->isEmpty())
            {{-- NO RESULTS --}}
            <div class="text-center py-20 bg-white rounded-3xl shadow-xl border-2 border-gray-100">
                <div class="w-24 h-24 mx-auto bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">No Results Found</h2>
                <p class="text-gray-600 mb-2 text-lg">
                    We couldn't find any products matching <strong>"{{ $query }}"</strong>
                </p>
                <p class="text-gray-500 mb-8">
                    Try adjusting your search terms or browse all products.
                </p>
                <div class="flex gap-4 justify-center">
                    <a href="{{ route('products.index') }}">
                        <button class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-4 rounded-2xl hover:shadow-lg transition-all font-semibold">
                            Browse All Products
                        </button>
                    </a>
                    <a href="{{ route('search') }}">
                        <button class="bg-gray-100 text-gray-700 px-8 py-4 rounded-2xl hover:bg-gray-200 transition-all font-semibold">
                            New Search
                        </button>
                    </a>
                </div>
            </div>
        @else
            {{-- SEARCH RESULTS --}}
            <div class="mb-8 flex items-center justify-between">
                <p class="text-gray-600 text-lg">
                    Showing <strong>{{ $products->firstItem() }}</strong> to <strong>{{ $products->lastItem() }}</strong> 
                    of <strong>{{ $products->total() }}</strong> results
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">
                @foreach($products as $product)
                    @php
                        $stockQty = (int)($product->quantity ?? 0);
                        $rating = (int)($product->average_rating ?? 0);
                        $firstImage = $product->main_image_url;

                        $isWishlisted = false;
                        if(auth()->check()) {
                            $isWishlisted = auth()->user()->wishlistProducts->contains($product->id);
                        }
                    @endphp

                    <div class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-gray-100 hover:border-green-400 group">
                        <div class="relative h-72 overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <img
                                    src="{{ $firstImage }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                    onerror="this.onerror=null;this.src='{{ asset('/flower.png') }}';"
                                />
                            </a>

                            <div class="absolute top-4 left-4">
                                <span class="px-4 py-2 rounded-full text-xs font-bold
                                    @if($stockQty > 5)
                                        bg-green-500/90 text-white
                                    @elseif($stockQty > 0)
                                        bg-yellow-400/90 text-gray-800
                                    @else
                                        bg-red-500/90 text-white
                                    @endif
                                ">
                                    @if($stockQty > 5) ✓ In Stock
                                    @elseif($stockQty > 0) ⚠ Low Stock
                                    @else ✗ Out of Stock @endif
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="mb-3">
                                <span class="text-xs text-green-600 font-bold uppercase tracking-wider bg-green-50 px-3 py-1 rounded-full">
                                    {{ $product->categoryRelation->name ?? 'Uncategorized' }}
                                </span>
                            </div>

                            <a href="{{ route('products.show', $product->slug) }}">
                                <h3 class="text-lg font-bold text-gray-800 mb-3 hover:text-green-600 transition-colors line-clamp-2 min-h-[3.5rem]">
                                    {{ $product->name }}
                                </h3>
                            </a>

                            <div class="flex items-center gap-1 mb-5">
                                @for($i=0; $i<5; $i++)
                                    <span class="text-sm {{ $i < $rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                @endfor
                                <span class="text-sm text-gray-500 ml-2 font-semibold">({{ $product->average_rating ?? 0 }})</span>
                            </div>

                            <div class="flex items-center justify-between pt-5 border-t-2 border-gray-100">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1 font-semibold">Price</p>
                                    <p class="text-2xl font-black text-gray-800">
                                        ${{ number_format($product->price, 2) }}
                                    </p>
                                </div>

                                <div class="flex gap-2">
                                    {{-- Add to Cart --}}
                                    <form method="POST" action="{{ route('cart.add', $product) }}">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button
                                            type="submit"
                                            @if($stockQty === 0) disabled @endif
                                            class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-3.5 rounded-2xl hover:shadow-lg transition-all
                                                disabled:from-gray-400 disabled:to-gray-500 disabled:cursor-not-allowed"
                                            title="{{ $stockQty > 0 ? 'Add to Cart' : 'Out of Stock' }}"
                                        >
                                            🛒
                                        </button>
                                    </form>

                                    {{-- Wishlist --}}
                                    @auth
                                        <form method="POST"
                                              action="{{ $isWishlisted ? route('wishlist.remove', $product->id) : route('wishlist.add', $product->id) }}"
                                              class="wishlist-form"
                                              data-product-id="{{ $product->id }}">
                                            @csrf
                                            @if($isWishlisted)
                                                @method('DELETE')
                                            @endif
                                            <button type="submit"
                                                class="p-3.5 rounded-2xl transition-all wishlist-btn
                                                    {{ $isWishlisted 
                                                        ? 'bg-red-500 text-white hover:bg-red-600' 
                                                        : 'bg-gray-100 text-gray-600 hover:bg-gray-200' 
                                                    }}"
                                                title="{{ $isWishlisted ? 'Remove from Wishlist' : 'Add to Wishlist' }}"
                                            >
                                                ♥
                                            </button>
                                        </form>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            @if($products->hasPages())
                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection

