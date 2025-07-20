<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://img.icons8.com/?size=100&id=TppIEnGI6LlY&format=png&color=000000" rel="stylesheet">
    <style> 
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f8fafc;
            background-image: `
                radial-gradient(#dbeafe 1px, transparent 1px),
                radial-gradient(#dbeafe 1px, transparent 1px)
            `;
            background-size: 40px 40px;
            background-position: 0 0, 20px 20px;
        } 
        .checkout-button {
            background-image: linear-gradient(to right, #3b82f6, #2563eb);
            transition: all 0.3s ease;
        }
        .checkout-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="bg-gray-100">

    <header class="bg-white shadow-sm">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center flex-shrink-0">
            <img src="https://img.icons8.com/?size=100&id=TppIEnGI6LlY&format=png&color=000000" class="h-8 w-8 mr-2"> <h1 class="text-2xl font-bold text-gray-800">Furniture</h1>
            </a>
            <div class="w-full max-w-lg mx-4">
                <form action="{{ route('home') }}" method="GET" class="relative">
                    <input type="text" name="search" placeholder="Search for products..." class="w-full py-2 pl-4 pr-10 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="absolute right-0 top-0 mt-2 mr-2 p-1">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
            </div>
            <a href="{{ route('cart.index') }}" class="relative p-2 bg-gray-100 rounded-full text-gray-600 hover:text-blue-600 hover:bg-blue-100 flex-shrink-0">
                <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs text-white">{{ count((array) session('cart')) }}</span>
            </a>
        </div>
    </header>

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Your Shopping Cart</h1>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('cart') && count(session('cart')) > 0)
            <div class="bg-white shadow-lg rounded-lg p-6">
                <table class="w-full text-left">
                    <thead>
                        <tr>
                            <th class="font-semibold text-gray-600 pb-4">Product</th>
                            <th class="font-semibold text-gray-600 pb-4">Quantity</th>
                            <th class="font-semibold text-gray-600 pb-4 text-right">Price</th>
                            <th class="font-semibold text-gray-600 pb-4 text-right">Subtotal</th>
                            <th class="font-semibold text-gray-600 pb-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0 @endphp
                        @foreach((array) session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <tr class="border-b">
                                <td class="py-4 flex items-center">
                                    <a href="{{ route('products.show', $id) }}">
                                        <img src="{{ $details['image'] }}" width="60" class="rounded-lg mr-4">
                                    </a>
                                    <a href="{{ route('products.show', $id) }}" class="font-medium hover:text-blue-600">{{ $details['name'] }}</a>
                                </td>
                                <td class="py-4">
                                    <form action="{{ route('cart.update') }}" method="POST" class="flex items-center">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <input type="number" name="quantity" value="{{ $details['quantity'] }}" class="w-16 text-center border rounded-md py-1">
                                        <button type="submit" class="ml-2 text-sm text-blue-600 hover:text-blue-800">Update</button>
                                    </form>
                                </td>
                                <td class="py-4 text-right">₹{{ number_format($details['price'], 2) }}</td>
                                <td class="py-4 text-right">₹{{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                                <td class="py-4 text-right">
                                    <a href="{{ route('cart.remove', $id) }}" class="text-red-600 hover:text-red-800 font-semibold">Remove</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right mt-8">
                    <p class="text-xl font-bold text-gray-800">Total: ₹{{ number_format($total, 2) }}</p>
                    <button class="checkout-button mt-4 text-white font-bold py-3 px-8 rounded-lg">Proceed to Checkout</button>
                </div>
            </div>
        @else
            <div class="text-center bg-white p-12 rounded-lg shadow-md">
                <p class="text-xl text-gray-600">Your cart is empty.</p>
                <a href="{{ route('home') }}" class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">Continue Shopping</a>
            </div>
        @endif
    </main>

</body>
</html>
