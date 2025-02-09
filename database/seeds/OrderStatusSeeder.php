<?php

use Illuminate\Database\Seeder;
use App\Models\OrderStatus;
class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i <3 ; $i++) { 
	    	OrderStatus::create([
	    		'color'=>'#008040',
	            'en'        =>  [ 'name' => 'Done'.$i],
	            'ar'        =>  ['name' => 'تم '.$i],
	        ]);
    	}

    }
}
