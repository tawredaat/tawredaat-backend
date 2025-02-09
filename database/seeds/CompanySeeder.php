<?php

use Illuminate\Database\Seeder;
use App\Models\Company;
class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i <3 ; $i++) { 
	    	Company::create([
	    		'company_email'        =>'email@samsung.com'.$i,
	    		'pri_contact_email'    =>'contact@samsung.com'.$i,

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
