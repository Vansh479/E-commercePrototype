<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furniture - Prototype</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://img.icons8.com/?size=100&id=TppIEnGI6LlY&format=png&color=000000" rel="icon">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center flex-shrink-0">
            <img src="https://img.icons8.com/?size=100&id=TppIEnGI6LlY&format=png&color=000000" class="h-8 w-8 mr-2"> 
                 <h1 class="text-2xl font-bold text-gray-800">Furniture</h1>
            </a>
            
            <div class="w-full max-w-lg mx-4">
                <form action="{{ route('home') }}" method="GET" class="relative">
                    <input type="text" name="search" placeholder="Search for products..." value="{{ $searchTerm ?? '' }}" class="w-full py-2 pl-4 pr-10 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="absolute right-0 top-0 mt-2 mr-2 p-1">
                    <img src="https://img.icons8.com/?size=100&id=TppIEnGI6LlY&format=png&color=000000" class="h-8 w-8 mr-2">                    </button>
                </form>
            </div>

            <a href="{{ route('cart.index') }}" class="relative p-2 bg-gray-100 rounded-full text-gray-600 hover:text-blue-600 hover:bg-blue-100 flex-shrink-0">
                <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs text-white">{{ count((array) session('cart')) }}</span>
            </a>
        </div>
    </header>

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="lg:flex lg:space-x-8">
            <aside class="lg:w-1/4 mb-8 lg:mb-0">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold mb-4">Filter</h3>
                    <form action="{{ route('home') }}" method="GET">
                        <select name="categories[]" onchange="this.form.submit()" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">All Categories</option>
                            @foreach($allCategories as $category)
                                <option value="{{ $category }}" {{ in_array($category, $selectedCategories ?? []) ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </aside>

            <div class="lg:w-3/4">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">
                        {{ $searchTerm ? "Showing results for '{$searchTerm}'" : (count($selectedCategories ?? []) > 0 ? implode(', ', $selectedCategories) : 'All Products') }}
                    </h3>
                    
                    <form action="{{ route('home') }}" method="GET" id="sort-form" class="flex items-center">
                        @foreach($selectedCategories as $category)
                            <input type="hidden" name="categories[]" value="{{ $category }}">
                        @endforeach
                        <input type="hidden" name="search" value="{{ $searchTerm ?? '' }}">
                        <select name="sort" onchange="this.form.submit()" class="border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">Sort by</option>
                            <option value="price_asc" {{ ($selectedSort ?? '') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ ($selectedSort ?? '') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </form>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($products as $product)
                        <a href="{{ route('products.show', ['id' => $product['id']]) }}" class="bg-white rounded-lg shadow-md overflow-hidden group block transform hover:-translate-y-1 transition-all duration-300">
                            <div class="relative">
                                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-56 object-cover">
                            </div>
                            <div class="p-4">
                                <p class="text-sm text-gray-500 mb-1">{{ $product['category'] }}</p>
                                <h4 class="font-semibold text-lg text-gray-800 truncate">{{ $product['name'] }}</h4>
                                <div class="flex justify-between items-center mt-3">
                                    <span class="font-bold text-xl text-gray-900">₹{{ number_format((float)$product['price'], 2) }}</span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center bg-white p-12 rounded-lg shadow-md">
                            <p class="text-xl text-gray-600">No products found matching your criteria.</p>
                            <a href="{{ route('home') }}" class="mt-4 inline-block text-blue-600 hover:underline">Clear filters</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

</body>
</html>
