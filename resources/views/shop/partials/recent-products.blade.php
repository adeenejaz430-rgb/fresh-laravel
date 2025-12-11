{{-- resources/views/shop/partials/recent-products.blade.php --}}
@if($recentProducts->isNotEmpty())
<section class="py-16 px-4 bg-white">
    <div class="container mx-auto">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl text-center md:text-4xl font-bold text-gray-800">
                Recent Products
            </h2>
            {{-- (Optional) arrows: you can wire these with a little JS if you want horizontal scroll --}}
        </div>

        {{-- Products grid (simpler than scroll slider – grid works great on Laravel) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($recentProducts as $product)
                @php
                    $stockQty = (int)($product->quantity ?? 0);
                    // Use the accessor that properly converts storage path to URL
                    $img = $product->main_image_url;
                @endphp
                <a href="{{ route('products.show', $product->slug) }}" class="bg-white border-2 border-green-200 rounded-2xl overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col cursor-pointer group block">
                    {{-- Image --}}
                    <div class="relative h-64 bg-gray-50 overflow-hidden">
                        <img
                            src="{{ $img }}"
                            alt="{{ $product->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            onerror="this.onerror=null;this.src='{{ asset('/flower.png') }}';"
                        >
                        <div class="absolute top-4 right-4">
                            <span class="bg-green-500 text-white text-xs font-semibold px-4 py-2 rounded-full">
                                {{ $product->category ?? 'Product' }}
                            </span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2 group-hover:text-green-600 transition-colors">
                            {{ $product->name }}
                        </h3>
                        <p class="text-gray-500 text-sm mb-4 flex-1">
                            {{ $product->description ?? 'Beautiful and high-quality product for your daily use.' }}
                        </p>

                        <div class="flex items-center justify-between mt-auto pt-4 border-t-2 border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Price</p>
                                <span class="text-2xl font-black bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                            </div>

                            <form class="add-to-cart-form" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" onclick="event.stopPropagation();">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button
                                    type="submit"
                                    @if($stockQty === 0) disabled @endif
                                    class="add-cart-btn group/btn px-5 py-3 rounded-xl font-semibold flex items-center gap-2 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105
                                        {{ $stockQty === 0 
                                            ? 'bg-gray-300 text-gray-600 cursor-not-allowed' 
                                            : 'bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white' 
                                        }}"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    {{ $stockQty === 0 ? 'Out of Stock' : 'Add to Cart' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif