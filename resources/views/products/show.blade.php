<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product['name'] }} - Furniture</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://img.icons8.com/?size=100&id=TppIEnGI6LlY&format=png&color=000000" rel="icon">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="https://img.icons8.com/?size=100&id=TppIEnGI6LlY&format=png&color=000000" class="h-8 w-8 mr-2">
                <h1 class="text-2xl font-bold text-gray-800">Furniture</h1>
            </a>
            <a href="{{ route('cart.index') }}" class="relative p-2 bg-gray-100 rounded-full text-gray-600 hover:text-blue-600 hover:bg-blue-100">
                <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs text-white">{{ count((array) session('cart')) }}</span>
            </a>
        </div>
    </header>

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 font-medium">&larr; Back to all products</a>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden md:flex">
            <div class="md:w-1/2">
                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover">
            </div>
            <div class="p-8 md:w-1/2 flex flex-col justify-center">
                <p class="text-sm text-gray-500 mb-2">{{ $product['category'] }}</p>
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $product['name'] }}</h1>
                <p class="text-gray-700 leading-relaxed mb-6">
                    {{ $product['description'] }}
                </p>
                <div class="flex items-center justify-between">
                    <span class="text-3xl font-bold text-gray-900">₹{{ number_format((float)$product['price'], 2) }}</span>
                    <a href="{{ route('cart.add', $product['id']) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300">
                        Add to Cart
                    </a>
                </div>
            </div>
        </div>
    </main>

</body>
</html>