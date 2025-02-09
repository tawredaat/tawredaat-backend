<?php

use Illuminate\Database\Seeder;
use App\Models\Country;
class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i <3 ; $i++) { 
	    	Country::create([
	    		'flag'      =>'undefinded',
	            'en'        =>  [
	            	'name' => 'Egypt'.$i,
	            	'alt'  => 'egy photo'.$i
	            	],
	            'ar'        =>  [
	            	'name' => 'مصر'.$i,
	            	'alt'  => 'علم مصر '.$i
	            	],
	        ]);
    	}

    }
}
