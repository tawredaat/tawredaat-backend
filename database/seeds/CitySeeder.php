<?php

use Illuminate\Database\Seeder;
use App\Models\City;
class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create([
            'en'    => ['name'             => 'Alexandria',],
            'ar'     => ['name'              => 'الإسكندرية',],
        ]);
        City::create([
            'en'    => ['name'             => 'Ismailia',],
            'ar'     => ['name'              => 'الإسماعيلية',],
        ]);
        City::create([
            'en'    => ['name'             => 'kafr el sheikh',],
            'ar'     => ['name'              => 'كفر الشيخ',],
        ]);
        City::create([
            'en'    => ['name'             => 'Asswan',],
            'ar'     => ['name'              => 'اسوان ',],
        ]);
        City::create([
            'en'    => ['name'             => 'Assiut',],
            'ar'     => ['name'              => 'أسيوط ',],
        ]);
        City::create([
            'en'    => ['name'             => 'Loxer',],
            'ar'     => ['name'              => 'الاقصر ',],
        ]);
        City::create([
            'en'    => ['name'             => 'El wadi El gedid',],
            'ar'     => ['name'              => 'الوادي الجديد ',],
        ]);
        City::create([
            'en'    => ['name'             => 'North Sinai',],
            'ar'     => ['name'              => 'شمال سيناء ',],
        ]);
        City::create([
            'en'    => ['name'             => 'El behira',],
            'ar'     => ['name'              => 'البحيرة',],
        ]);
        City::create([
            'en'    => ['name'             => 'Bani Sweif',],
            'ar'     => ['name'              => 'بنني سويف',],
        ]);

        City::create([
            'en'    => ['name'             => 'Bor said',],
            'ar'     => ['name'              => 'بورسعيد ',],
        ]);
        City::create([
            'en'    => ['name'             => 'Red Sea',],
            'ar'     => ['name'              => 'البحر الاحمر ',],
        ]);
        City::create([
            'en'    => ['name'             => 'Giza',],
            'ar'     => ['name'              => 'الجيزة  ',],
        ]);
        City::create([
            'en'    => ['name'             => 'El dakahlya',],
            'ar'     => ['name'              => 'الدقهلية  ',],
        ]);
        City::create([
            'en'    => ['name'             => 'South Sinai',],
            'ar'     => ['name'              => 'جنوب سيناء  ',],
        ]);
        City::create([
            'en'    => ['name'             => 'Damietta',],
            'ar'     => ['name'              => 'دمياط  ',],
        ]);
        City::create([
            'en'    => ['name'             => 'Sohag',],
            'ar'     => ['name'              => 'سوهاج  ',],
        ]);
        City::create([
            'en'    => ['name'             => 'Suez',],
            'ar'     => ['name'              => 'السويس  ',],
        ]);
        City::create([
            'en'    => ['name'             => 'El sharqiya',],
            'ar'     => ['name'              => 'الشرقية  ',],
        ]);
        City::create([
            'en'    => ['name'             => 'El gharbia',],
            'ar'     => ['name'              => 'الغربية  ',],
        ]);
        City::create([
            'en'    => ['name'             => 'El fayoum',],
            'ar'     => ['name'              => 'الفيوم  ',],
        ]);
        City::create([
            'en'    => ['name'             => 'Cairo',],
            'ar'     => ['name'              => 'القاهرة  ',],
        ]);
        City::create([
            'en'    => ['name'             => 'El qalubia',],
            'ar'     => ['name'              => 'القليوبيه  ',],
        ]);
        City::create([
            'en'    => ['name'             => 'Qena',],
            'ar'     => ['name'              => 'قنا  ',],
        ]);
        City::create([
            'en'    => ['name'             => 'Matrouh',],
            'ar'     => ['name'              => 'مطروح  ',],
        ]);
        City::create([
            'en'    => ['name'             => 'El monofia',],
            'ar'     => ['name'              => 'المنوفية  ',],
        ]);
        City::create([
            'en'    => ['name'             => 'El minya',],
            'ar'     => ['name'              => 'المنيا  ',],
        ]);
    }
}
