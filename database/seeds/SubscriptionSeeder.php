<?php

use Illuminate\Database\Seeder;
use App\Models\Subscription;
class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i <3 ; $i++) { 
	    	Subscription::create([
	    		'durationInMonth'=>5,
	    		'price'  	 	 =>  300,
	    		'rank_points'  	 => 500,
	            'en'             =>  [ 'name' => 'Done'.$i],
	            'ar'             =>  ['name' => 'تم '.$i],
	        ]);
    	}

    }
}
