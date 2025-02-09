<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*$this->call(UserSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(CompanyTypeSeeder::class);
        $this->call(SpecificationSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(PromoCodeSeeder::class);
        $this->call(SubscriptionSeeder::class);
        $this->call(AdBannerSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(NewOrderStatusSeeder::class);*/
        $this->call(OrderStatusSeeder::class);

    }
}
