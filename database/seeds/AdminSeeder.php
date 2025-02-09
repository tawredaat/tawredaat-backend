<?php

use Illuminate\Database\Seeder;
use App\Admin;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create(['name'=>'admin','password'=>bcrypt('1234567890'),'email'=>'admin@admin.com','privilege'=>'super']);
    }
}
