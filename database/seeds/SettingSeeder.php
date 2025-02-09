<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;
class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            Setting::create([
                'email' 	=> 'customercare@souqkahraba.com',
                'logo' 		=> 'edit logo',
                'phone'		=> '+20 0100 3500 790',
                'fax' 		=> '123456789',
                'facebook' 	=> 'https://web.facebook.com/MELgebaly96',
                'insta' 	=> 'https://instagram.com',
                'youtube' 	=> 'https://www.youtube.com/',
                'linkedin' 	=> 'https://www.linkedin.com/feed/',	
                'twitter' 	=> 'https://twitter.com/',	
                'en'=> [
                        'description' => 'Our website "SouqKahraba.com " is professionally created to make all the market online. With its user-friendly interface, companies can easily show their products and services via web portals; they acquire accounts that has an online store to show all products, datasheets, Pricelists, full Company Profile, etc. This makes companies connect with each other easier and faster and more effective. Simply, it is a full guide of the electricity market.',
                        'address' 	  => '18 El Quds El Sharif, Mohandessin, Giza, Egypt',
                        'logo_alt'    => 'souqkahrba',
                        ],
               'ar' => [
                        'description' => '
تم إنشاء موقعنا على الإنترنت "SouqKahraba.com" بشكل احترافي لجعل جميع الأسواق على الإنترنت. من خلال واجهة سهلة الاستخدام ، يمكن للشركات أن تعرض منتجاتها وخدماتها بسهولة عبر بوابات الويب ؛ لديهم حسابات لها متجر على الإنترنت لإظهار جميع المنتجات وأوراق البيانات وقوائم الأسعار وملف الشركة بالكامل وما إلى ذلك ، مما يجعل الشركات تتواصل مع بعضها البعض بشكل أسهل وأسرع وأكثر فعالية. ببساطة ، إنه دليل كامل لسوق الكهرباء.',
                        'address' 	  => '18 القدس الشريف ، المهندسين ، الجيزة ، مصر',
                        'logo_alt'    => 'souqkahrba',

                        ],
            ]);

    }
}
