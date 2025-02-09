<?php

use Illuminate\Database\Seeder;
use App\Models\Promocode;
class PromoCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i <3 ; $i++) { 
	    	Promocode::create([
	    		'code'=>'008040'.$i,
	    		'discount'  	 =>  '20',
	    		'discount_type'  =>  'value',
	            'en'             =>  [ 'name' => 'Done'.$i],
	            'ar'             =>  ['name' => 'تم '.$i],
	        ]);
    	}

    }
}
