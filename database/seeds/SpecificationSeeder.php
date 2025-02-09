<?php

use Illuminate\Database\Seeder;
use App\Models\Specification;
class SpecificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i <3 ; $i++) { 
	    	Specification::create([
	            'en'        =>  [ 'name' => 'size'.$i],
	            'ar'        =>  ['name' => 'حجم '.$i],
	        ]);
    	}

    }
}
