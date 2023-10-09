<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Product,FeedbackCategory,User};
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::updateOrCreate(['email'=>"admin@gmail.com"],['name' => 'Admin','type'=>'1','email'=>"admin@gmail.com",'password'=>Hash::make('asdfghjkl;')]);
        
        foreach([['title' => 'Dell 5490','slug' => Product::uniqueSlug('Dell 5490'),'summary' => 'this is best product of laptop','price'=>55000],['title' => 'Dell 5480','slug' => Product::uniqueSlug('Dell 5480'),'summary' => 'this is best product of laptop','price'=>45000]] as $product){
            Product::updateOrCreate(['slug' => $product['slug']],['title' => $product['title'],'slug' => $product['slug'],'summary' => $product['summary'],'price'=>$product['price']]);
        }

        foreach(["bug report",'feature request','improvement'] as $category){
            FeedbackCategory::updateOrCreate(['title' =>$category],['title' => $category]);
        }
    }
}
