<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Product;
class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	for ($i=0; $i < 10; $i++) { 
    		Product::firstOrCreate([
	            'name' => 'Product'.$i,
	            'description' => Str::random(20),
	        ]);
    	}
    }
}
