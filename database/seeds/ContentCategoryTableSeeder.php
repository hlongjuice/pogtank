<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Content\ContentCategory;
use Carbon\Carbon;

class ContentCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTable();
        DB::transaction(function (){
            $categories = collect([
                ['title' => 'About Us'],
                ['title' => 'Contact'],
                ['title' => 'Slide'],
                ['title' => 'Portfolio']
            ]);
            foreach ($categories as $category){
                ContentCategory::create($category);
            }
        });
    }

    public function truncateTable()
    {
        DB::table('content_categories')->truncate();
//        \App\Models\Admin\Content\ContentCategory::truncate();
    }
}
