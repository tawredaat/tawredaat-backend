<?php

use Illuminate\Database\Seeder;
use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['name'=>'User','password'=>bcrypt('1234567890'),'email'=>'user@user.com','phone'=>'0101111002','photo'=>'undefined']);
    }
}
