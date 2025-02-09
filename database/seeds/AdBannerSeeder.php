<?php

use Illuminate\Database\Seeder;
use App\Models\AdBanner;
class AdBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            AdBanner::create([
                'en'=> [
                        'firstImage'   => 'firstImage_en',
                        'secondImage'   => 'secondImage_en',
                        'firstImageAlt'  => 'firstImageAlt_en',
                        'secondImageAlt'=> 'secondImageAlt_en',
                        ],
               'ar' => [
                        'firstImage'   => 'firstImage_ar',
                        'secondImage'   => 'secondImage_ar',
                        'firstImageAlt'  => 'firstImageAlt_ar',
                        'secondImageAlt'=> 'secondImageAlt_ar',
                        ],
            ]);

    }
}
