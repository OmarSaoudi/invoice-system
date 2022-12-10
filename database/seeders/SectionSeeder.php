<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sections')->delete();
        $sections = [
            ['en'=> 'Cleaning materials', 'ar'=> 'مواد التنظيف'],
            ['en'=> 'Media automated', 'ar'=> 'الإعلام الألي'],
            ['en'=> 'Home appliances', 'ar'=> 'الأجهزة الكهرومنزلية'],
        ];

        foreach ($sections as $section) {
            Section::create([
                'name' => $section,
                'notes' => 'Good',
            ]);
        }
    }
}
