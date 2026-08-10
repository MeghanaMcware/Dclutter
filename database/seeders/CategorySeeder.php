<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoriesData = [
            [
                'name' => 'Furniture',
                'icon' => 'fa-couch',
                'subcategories' => [
                    ['name' => 'Cots', 'icon' => 'fa-bed'],
                    ['name' => 'Sofas', 'icon' => 'fa-couch'],
                    ['name' => 'Chairs', 'icon' => 'fa-chair'],
                    ['name' => 'Tables', 'icon' => 'fa-table'],
                    ['name' => 'Cupboards', 'icon' => 'fa-door-closed'],
                    ['name' => 'Other Furniture', 'icon' => 'fa-layer-group'],
                ]
            ],
            [
                'name' => 'Mattresses & Cushions',
                'icon' => 'fa-bed',
                'subcategories' => [
                    ['name' => 'Single Mattress', 'icon' => 'fa-bed'],
                    ['name' => 'Double Mattress', 'icon' => 'fa-bed'],
                    ['name' => 'Pillows', 'icon' => 'fa-cloud'],
                    ['name' => 'Cushions', 'icon' => 'fa-cube'],
                ]
            ],
            [
                'name' => 'Clothes & Shoes',
                'icon' => 'fa-shirt',
                'subcategories' => [
                    ['name' => 'Men\'s Clothing', 'icon' => 'fa-user-tie'],
                    ['name' => 'Women\'s Clothing', 'icon' => 'fa-person-dress'],
                    ['name' => 'Kids Clothing', 'icon' => 'fa-child'],
                    ['name' => 'Shoes', 'icon' => 'fa-shoe-prints'],
                    ['name' => 'Bags', 'icon' => 'fa-bag-shopping'],
                ]
            ],
            [
                'name' => 'Household appliances',
                'icon' => 'fa-plug-circle-bolt',
                'subcategories' => [
                    ['name' => 'Refrigerator', 'icon' => 'fa-snowflake'],
                    ['name' => 'Washing Machine', 'icon' => 'fa-soap'],
                    ['name' => 'Microwave', 'icon' => 'fa-fire-burner'],
                    ['name' => 'Mixer Grinder', 'icon' => 'fa-blender'],
                    ['name' => 'TV', 'icon' => 'fa-tv'],
                    ['name' => 'Other Appliances', 'icon' => 'fa-plug'],
                ]
            ],
            [
                'name' => 'Electronics',
                'icon' => 'fa-laptop',
                'subcategories' => [
                    ['name' => 'Laptops/Computers', 'icon' => 'fa-laptop'],
                    ['name' => 'Mobile Phones', 'icon' => 'fa-mobile-screen'],
                    ['name' => 'Printers', 'icon' => 'fa-print'],
                    ['name' => 'Cables/Chargers', 'icon' => 'fa-plug'],
                    ['name' => 'Other Electronics', 'icon' => 'fa-microchip'],
                ]
            ],
            [
                'name' => 'Books & Magazines',
                'icon' => 'fa-book-open',
                'subcategories' => [
                    ['name' => 'School Books', 'icon' => 'fa-book'],
                    ['name' => 'Novels', 'icon' => 'fa-book-open'],
                    ['name' => 'Magazines', 'icon' => 'fa-newspaper'],
                    ['name' => 'Newspapers', 'icon' => 'fa-file-lines'],
                ]
            ],
            [
                'name' => 'Toys & Games',
                'icon' => 'fa-puzzle-piece',
                'subcategories' => [
                    ['name' => 'Soft Toys', 'icon' => 'fa-paw'],
                    ['name' => 'Board Games', 'icon' => 'fa-chess-board'],
                    ['name' => 'Electronic Toys', 'icon' => 'fa-gamepad'],
                    ['name' => 'Bicycles', 'icon' => 'fa-bicycle'],
                ]
            ],
            [
                'name' => 'Other Items',
                'icon' => 'fa-box-open',
                'subcategories' => [
                    ['name' => 'Utensils', 'icon' => 'fa-utensils'],
                    ['name' => 'Plastic Items', 'icon' => 'fa-bottle-water'],
                    ['name' => 'Glassware', 'icon' => 'fa-wine-glass'],
                    ['name' => 'Miscellaneous', 'icon' => 'fa-box-open'],
                ]
            ],
        ];

        foreach ($categoriesData as $catData) {
            $category = Category::firstOrCreate(
                ['name' => $catData['name']],
                ['icon' => $catData['icon'], 'status' => true]
            );

            foreach ($catData['subcategories'] as $subcatData) {
                Subcategory::firstOrCreate(
                    ['category_id' => $category->id, 'name' => $subcatData['name']],
                    ['icon' => $subcatData['icon'], 'status' => true]
                );
            }
        }
    }
}
