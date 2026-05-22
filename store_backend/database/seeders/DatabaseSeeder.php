<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Professional Administrative Users
        $admin = User::updateOrCreate(['email' => 'admin@fooddash.com'], [
            'name' => 'System Director',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'role' => User::ROLE_ADMIN,
        ]);

        $owner = User::updateOrCreate(['email' => 'owner@burgerlab.com'], [
            'name' => 'Platform Executive',
            'password' => Hash::make('password'),
            'role' => User::ROLE_OWNER,
            'phone' => '+92 300 1234567',
            'address' => 'F-7 Markaz, Islamabad',
        ]);

        $customer = User::updateOrCreate(['email' => 'ahmed@example.com'], [
            'name' => 'Premium Member',
            'password' => Hash::make('password'),
            'role' => User::ROLE_CUSTOMER,
            'phone' => '+92 309 4586205',
            'address' => 'F-9, Islamabad',
        ]);

        // 2. Curated 'Big 5' Food Categories
        $categories = [
            ['name' => 'Burgers', 'slug' => 'burgers', 'image' => 'https://images.unsplash.com/photo-1571091718767-18b5b1457add?q=80&w=1000'],
            ['name' => 'Pizza', 'slug' => 'pizza', 'image' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=1000'],
            ['name' => 'Continental', 'slug' => 'continental', 'image' => 'https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=1000'],
            ['name' => 'Traditional', 'slug' => 'traditional', 'image' => 'https://images.unsplash.com/photo-1589187151032-573a91317445?q=80&w=1000'],
            ['name' => 'Sweet Tooth', 'slug' => 'desserts', 'image' => 'https://images.unsplash.com/photo-1551024506-0bccd828d307?q=80&w=1000'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 3. Premium Restaurants (Stunning Exterior/Interior)
        $restaurantsData = [
            [
                'name' => 'Burger Lab Premium',
                'description' => 'Elite smashed burgers crafted with artisanal brioche and premium wagyu beef.',
                'image' => 'https://images.unsplash.com/photo-1594212699903-ec8a3eca50f5?q=80&w=1000',
                'banner' => 'https://images.unsplash.com/photo-1550547660-d9450f859349?q=80&w=2000',
                'address' => 'F-7 Markaz, Islamabad', 'delivery_time' => 20, 'min_order' => 850, 'rating' => 4.9
            ],
            [
                'name' => 'Pizza Hut Elite',
                'description' => 'Modern Italian dining experience featuring wood-fired artisanal pizzas.',
                'image' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=1000',
                'banner' => 'https://images.unsplash.com/photo-1590947132387-155cc02f3212?q=80&w=2000',
                'address' => 'Blue Area, Islamabad', 'delivery_time' => 30, 'min_order' => 1200, 'rating' => 4.7
            ],
            [
                'name' => 'The Monal Sky',
                'description' => 'Fine dining at the peak of the Margalla Hills with panoramic views.',
                'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1000',
                'banner' => 'https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=2000',
                'address' => 'Margalla Hills, Islamabad', 'delivery_time' => 45, 'min_order' => 2500, 'rating' => 5.0
            ],
            [
                'name' => 'Savour Heritage',
                'description' => 'The golden standard of heritage Pulao and artisanal Kababs.',
                'image' => 'https://images.unsplash.com/photo-1601050690597-df056fb4ce7c?q=80&w=1000',
                'banner' => 'https://images.unsplash.com/photo-1585937421612-70a0f261c0b8?q=80&w=2000',
                'address' => 'G-9 Markaz, Islamabad', 'delivery_time' => 15, 'min_order' => 450, 'rating' => 4.6
            ],
            [
                'name' => 'KFC Express',
                'description' => 'Crispy golden chicken fried to absolute perfection with unique spices.',
                'image' => 'https://images.unsplash.com/photo-1513639776629-7b61b0ac59b3?q=80&w=1000',
                'banner' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=2000',
                'address' => 'F-10 Markaz, Islamabad', 'delivery_time' => 25, 'min_order' => 700, 'rating' => 4.5
            ],
            [
                'name' => 'McDonalds Royal',
                'description' => 'Classic world-famous golden fries, signature burgers, and sundaes.',
                'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=1000',
                'banner' => 'https://images.unsplash.com/photo-1550547660-d9450f859349?q=80&w=2000',
                'address' => 'F-9 Park, Islamabad', 'delivery_time' => 18, 'min_order' => 600, 'rating' => 4.6
            ],
            [
                'name' => 'Cheezious Gold',
                'description' => 'Unbelievably rich and cheesy deep dish pizza and loaded hot rolls.',
                'image' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=1000',
                'banner' => 'https://images.unsplash.com/photo-1590947132387-155cc02f3212?q=80&w=2000',
                'address' => 'E-11 Sector, Islamabad', 'delivery_time' => 30, 'min_order' => 900, 'rating' => 4.8
            ],
            [
                'name' => 'Howdy Grillhouse',
                'description' => 'A wild-west themed premium live charcoal grill and flame-kissed burgers.',
                'image' => 'https://images.unsplash.com/photo-1550547660-d9450f859349?q=80&w=1000',
                'banner' => 'https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=2000',
                'address' => 'F-7 Markaz, Islamabad', 'delivery_time' => 22, 'min_order' => 1000, 'rating' => 4.7
            ],
            [
                'name' => 'Tehzeeb Boulangerie',
                'description' => 'Legacy bakery and café offering fresh gourmet salads, puffs, and sweet treats.',
                'image' => 'https://images.unsplash.com/photo-1551024506-0bccd828d307?q=80&w=1000',
                'banner' => 'https://images.unsplash.com/photo-1501443762994-82bd5dace89a?q=80&w=2000',
                'address' => 'G-11 Markaz, Islamabad', 'delivery_time' => 20, 'min_order' => 500, 'rating' => 4.9
            ],
            [
                'name' => 'Chacha Jee Food',
                'description' => 'Elite traditional street food classics, fresh lassi, and hot biryani.',
                'image' => 'https://images.unsplash.com/photo-1589187151032-573a91317445?q=80&w=1000',
                'banner' => 'https://images.unsplash.com/photo-1512058560566-42724afbc2aa?q=80&w=2000',
                'address' => 'Centaurus Mall, Islamabad', 'delivery_time' => 25, 'min_order' => 400, 'rating' => 4.5
            ],
            [
                'name' => 'Optp Crispy Fries',
                'description' => 'Natural potato fries tossed in secret garlic sauce and tender wings.',
                'image' => 'https://images.unsplash.com/photo-1576107232684-1279f390859f?q=80&w=1000',
                'banner' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=2000',
                'address' => 'I-8 Markaz, Islamabad', 'delivery_time' => 15, 'min_order' => 350, 'rating' => 4.4
            ],
            [
                'name' => 'Ox and Grill',
                'description' => 'Sensational sizzling hot plates, grilled steak, and continental specialties.',
                'image' => 'https://images.unsplash.com/photo-1600891964599-f61ba0e24092?q=80&w=1000',
                'banner' => 'https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=2000',
                'address' => 'I-8 Markaz, Islamabad', 'delivery_time' => 35, 'min_order' => 1500, 'rating' => 4.7
            ],
            [
                'name' => 'Ginsoy Extreme',
                'description' => 'Elite premium Hakka style Chinese dining experience with rich hot-pots.',
                'image' => 'https://images.unsplash.com/photo-1525755662778-989d0524087e?q=80&w=1000',
                'banner' => 'https://images.unsplash.com/photo-1512058560566-42724afbc2aa?q=80&w=2000',
                'address' => 'Blue Area, Islamabad', 'delivery_time' => 30, 'min_order' => 1100, 'rating' => 4.8
            ],
            [
                'name' => 'Hardees Thickburgers',
                'description' => 'Elite charbroiled thick beef burgers and hand-scooped malts.',
                'image' => 'https://images.unsplash.com/photo-1550547660-d9450f859349?q=80&w=1000',
                'banner' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=2000',
                'address' => 'F-11 Markaz, Islamabad', 'delivery_time' => 20, 'min_order' => 800, 'rating' => 4.6
            ],
            [
                'name' => 'Second Cup Bistro',
                'description' => 'Warm, artisanal European-style brewed coffee, muffins, and paninis.',
                'image' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?q=80&w=1000',
                'banner' => 'https://images.unsplash.com/photo-1501443762994-82bd5dace89a?q=80&w=2000',
                'address' => 'F-11 Markaz, Islamabad', 'delivery_time' => 15, 'min_order' => 500, 'rating' => 4.8
            ],
            [
                'name' => 'Roasters Specialty',
                'description' => 'Elite micro-roasted espresso drinks and a modern international kitchen.',
                'image' => 'https://images.unsplash.com/photo-1498804103079-a6351b050096?q=80&w=1000',
                'banner' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=2000',
                'address' => 'F-6 Super Market, Islamabad', 'delivery_time' => 20, 'min_order' => 750, 'rating' => 4.9
            ]
        ];

        foreach ($restaurantsData as $r) {
            $restaurant = Restaurant::updateOrCreate(['slug' => Str::slug($r['name'])], array_merge($r, [
                'owner_id' => $owner->id,
            ]));

            $this->seedFoodItems($restaurant);
        }
    }

    private function seedFoodItems($restaurant)
    {
        $foodData = [
            'burgers' => [
                ['name' => 'Signature Wagyu Smash', 'price' => 1250, 'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=1000'],
                ['name' => 'Black Truffle Pro', 'price' => 1450, 'image' => 'https://images.unsplash.com/photo-1571091718767-18b5b1457add?q=80&w=1000'],
            ],
            'pizza' => [
                ['name' => 'Artisanal Margherita', 'price' => 1850, 'image' => 'https://images.unsplash.com/photo-1604068549290-dea0e4a305ca?q=80&w=1000'],
                ['name' => 'Spicy Diavola Elite', 'price' => 2200, 'image' => 'https://images.unsplash.com/photo-1534308983496-4fabb1a015ee?q=80&w=1000'],
            ],
            'continental' => [
                ['name' => 'Prime Ribeye Steak', 'price' => 5200, 'image' => 'https://images.unsplash.com/photo-1600891964599-f61ba0e24092?q=80&w=1000'],
                ['name' => 'Glazed Salmon Fillet', 'price' => 4800, 'image' => 'https://images.unsplash.com/photo-1485921325833-c519f76c4927?q=80&w=1000'],
            ],
            'traditional' => [
                ['name' => 'Premium Mutton Pulao', 'price' => 2400, 'image' => 'https://images.unsplash.com/photo-1589187151032-573a91317445?q=80&w=1000'],
                ['name' => 'Heritage Seekh Platter', 'price' => 1800, 'image' => 'https://images.unsplash.com/photo-1601050690597-df056fb4ce7c?q=80&w=1000'],
            ],
            'desserts' => [
                ['name' => 'Belgian Choco Melt', 'price' => 950, 'image' => 'https://images.unsplash.com/photo-1551024506-0bccd828d307?q=80&w=1000'],
                ['name' => 'Artisan Gelato Scoop', 'price' => 450, 'image' => 'https://images.unsplash.com/photo-1501443762994-82bd5dace89a?q=80&w=1000'],
            ]
        ];

        foreach ($foodData as $catSlug => $items) {
            $category = Category::where('slug', $catSlug)->first();
            if (!$category) continue;

            foreach ($items as $item) {
                Product::create([
                    'restaurant_id' => $restaurant->id,
                    'category_id' => $category->id,
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name'] . '-' . $restaurant->id . '-' . rand(1, 999)),
                    'description' => 'A masterfully crafted ' . $item['name'] . ' using high-fidelity artisanal ingredients.',
                    'price' => $item['price'],
                    'sale_price' => rand(0, 1) ? $item['price'] * 0.9 : null,
                    'quantity' => 100,
                    'image' => $item['image'],
                    'is_featured' => true, 'is_active' => true, 'is_available' => true, 'preparation_time' => rand(20, 35)
                ]);
            }
        }
    }
}
