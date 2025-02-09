<?php

use Illuminate\Database\Seeder;
use App\Models\Brand;
class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i <3 ; $i++) { 
	    	Brand::create([
	    		'image'        =>'undefined'.$i,
	            'en'   =>  [
	            	'name' => 'samsung'.$i,
	            	'title' => 'samsung title'.$i,
	            	'alt'  => 'samsung photo'.$i
	            	],
	            'ar'        =>  [
	            	'name' => 'سامسونج'.$i,
	            	'title' => 'سامسونج'.$i,
	            	'alt'  => 'علم سامسونج '.$i
	            	],
	        ]);
    	}

    }
}
