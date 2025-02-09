<?php

use Illuminate\Database\Seeder;
use App\Models\Area;
class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i <3 ; $i++) { 
	    	Area::create([
	            'en'        =>  [ 'name' => 'Cairo'.$i],
	            'ar'        =>  ['name' => 'القاهره '.$i],
	        ]);
    	}

    }
}
