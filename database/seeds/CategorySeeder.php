<?php

use Illuminate\Database\Seeder;
use App\Models\Category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    	Category::create([
	    		'level'        =>'level1',
	            'en'   =>  [
	            	'name' => 'Category l1',
	            	'title' => 'Category l1 title',
	            	'alt'  => 'Category l1 photo'
	            	],
	            'ar'        =>  [
	            	'name' => 'فئة',
	            	'title' => 'فئة',
	            	'alt'  => 'علم فئة '
	            	],
	        ]);
	   		Category::create([
	    		'level'        =>'level2',
	    		'parent'        =>1,
	            'en'   =>  [
	            	'name' => 'Category l2',
	            	'title' => 'Category l2 title',
	            	'alt'  => 'Category l2 photo'
	            	],
	            'ar'        =>  [
	            	'name' => 'فئة',
	            	'title' => 'فئة',
	            	'alt'  => 'علم فئة '
	            	],
	        ]);
	        for ($i=0; $i <3 ; $i++) { 
	        	Category::create([
	    		'level'        =>'level3',
	    		'parent'        =>2,
	            'en'   =>  [
	            	'name' => 'electronic'.$i,
	            	'title' => 'Category l3 title'.$i,
	            	'alt'  => 'Category l3 photo'.$i
	            	],
	            'ar'        =>  [
	            	'name' => 'فئة'.$i,
	            	'title' => 'فئة'.$i,
	            	'alt'  => 'علم فئة '.$i
	            	],
	       		]);
	        }

    }
}
