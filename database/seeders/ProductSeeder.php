<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->delete();

        $products = [
            ['en'=> 'soap', 'ar'=> 'صابون'],
            ['en'=> 'computer', 'ar'=> 'حاسوب'],
            ['en'=> 'refrigerator', 'ar'=> 'ثلاجة'],
        ];

        foreach ($products as $product) {
            Product::create([
            'name' => $product,
            'section_id' => Section::all()->unique()->random()->id,
            'notes' => 'Good',
            ]);
        }
    }
}
