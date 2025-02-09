<?php

use Illuminate\Database\Seeder;
use App\Models\Unit;
class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i <3 ; $i++) { 
	    	Unit::create([
	            'en'        =>  ['name' => 'kilo'.$i],
	            'ar'        =>  ['name' => 'طيلو'.$i],
	        ]);
    	}

    }
}
