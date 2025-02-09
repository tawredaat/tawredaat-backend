<?php

use Illuminate\Database\Seeder;
use App\Models\Product;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i <3 ; $i++) { 
	    	Product::create([
	    		'image'        =>'undefined'.$i,
	    		'brand_id'        =>1,
	    		'category_id'        =>3,
	            'en'   =>  [
	            	'name' => 'Samsung A70'.$i,
	            	'title' => 'Samsung A70 title'.$i,
	            	'alt'  => 'Samsung A70 photo'.$i
	            	],
	            'ar'        =>  [
	            	'name' => 'A70'.$i,
	            	'title' => 'A70'.$i,
	            	'alt'  => 'علم A70 '.$i
	            	],
	        ]);
    	}

    }
}
