<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class StaticProductController extends Controller
{
    private $products = [
        [
            'id' => 1,
            'name' => 'Modern Office Chair',
            'category' => 'Office Furniture',
            'price' => '12500.00',
            'image' => 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg',
            'description' => 'An ergonomic office chair with adjustable height, lumbar support, and a breathable mesh back. Perfect for long hours of work.'
        ],
        [
            'id' => 2,
            'name' => 'Oak Wood Dining Table',
            'category' => 'Dining Room',
            'price' => '35000.00',
            'image' => 'https://images.pexels.com/photos/3952048/pexels-photo-3952048.jpeg',
            'description' => 'A beautiful solid oak dining table that comfortably seats six people. Its minimalist design fits any modern home.'
        ],
        [
            'id' => 3,
            'name' => 'Plush Velvet Sofa',
            'category' => 'Living Room',
            'price' => '55999.00',
            'image' => 'https://images.pexels.com/photos/7045771/pexels-photo-7045771.jpeg',
            'description' => 'A luxurious 3-seater sofa upholstered in soft velvet fabric. Features deep, comfortable cushions and a sturdy wooden frame.'
        ],
        [
            'id' => 4,
            'name' => 'King Size Bed Frame',
            'category' => 'Bedroom',
            'price' => '42000.00',
            'image' => 'https://images.pexels.com/photos/6987719/pexels-photo-6987719.jpeg',
            'description' => 'A stylish and durable king-size bed frame with an upholstered headboard and solid wood slats for support.'
        ],
        [
            'id' => 5,
            'name' => 'Compact Bookshelf',
            'category' => 'Storage',
            'price' => '8500.00',
            'image' => 'https://images.pexels.com/photos/5975986/pexels-photo-5975986.jpeg',
            'description' => 'A compact and modern bookshelf with five tiers of shelving, perfect for small spaces.'
        ],
        [
            'id' => 6,
            'name' => 'Ergonomic Study Desk',
            'category' => 'Office Furniture',
            'price' => '18000.00',
            'image' => 'https://images.pexels.com/photos/8092309/pexels-photo-8092309.jpeg',
            'description' => 'A spacious study desk with a built-in drawer and a sleek, minimalist design.'
        ],
        [
            'id' => 7,
            'name' => 'Outdoor Patio Set',
            'category' => 'Outdoor',
            'price' => '28500.00',
            'image' => 'https://images.pexels.com/photos/25328879/pexels-photo-25328879.jpeg',
            'description' => 'A 4-piece outdoor patio set including a loveseat, two chairs, and a coffee table. Weather-resistant and stylish.'
        ],
        [
            'id' => 8,
            'name' => 'Kitchen Island Cart',
            'category' => 'Kitchen',
            'price' => '15500.00',
            'image' => 'https://images.pexels.com/photos/7534541/pexels-photo-7534541.jpeg',
            'description' => 'A versatile kitchen cart with a solid wood top, two shelves, and wheels for easy mobility. Provides extra storage and counter space.'
        ]
    ];

    public function index(Request $request)
    {
        $productsToDisplay = new Collection($this->products);
        $selectedCategories = $request->input('categories', []);
        $sort = $request->input('sort');
        $search = $request->input('search');

        if ($search) {
            $productsToDisplay = $productsToDisplay->filter(function ($product) use ($search) {
                return Str::contains(strtolower($product['name']), strtolower($search));
            });
        }

        if (!empty($selectedCategories)) {
            $productsToDisplay = $productsToDisplay->whereIn('category', $selectedCategories);
        }

        if ($sort === 'price_asc') {
            $productsToDisplay = $productsToDisplay->sortBy('price');
        } elseif ($sort === 'price_desc') {
            $productsToDisplay = $productsToDisplay->sortByDesc('price');
        }

        $allCategories = array_unique(Arr::pluck($this->products, 'category'));

        return view('welcome', [
            'products' => $productsToDisplay,
            'allCategories' => $allCategories,
            'selectedCategories' => $selectedCategories,
            'selectedSort' => $sort,
            'searchTerm' => $search
        ]);
    }

    public function show($id)
    {
        $product = collect($this->products)->firstWhere('id', $id);
        if (!$product) abort(404);
        return view('products.show', compact('product'));
    }
}
