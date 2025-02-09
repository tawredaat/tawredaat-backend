<?php

use Illuminate\Database\Seeder;
use App\Models\CompanyType;
class CompanyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i <3 ; $i++) { 
	    	CompanyType::create([
	            'en'        =>  [ 'name' => 'Mobiles'.$i],
	            'ar'        =>  ['name' => 'هواتف محمول '.$i],
	        ]);
    	}

    }
}
