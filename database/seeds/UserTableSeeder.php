<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = Role::where('name', 'user')->first();
        $role_admin = Role::where('name', 'admin')->first();

        $user = new User();
        $user->name = 'adamprvy';
        $user->email = 'adamprvy@mail.com';
        $user->password = bcrypt('password');
        $user->save();

        $admin = new User();
        $admin->name = 'admin';
        $admin->email = 'admin@adminmail.sk';
        $admin->password = bcrypt('adminpassword');
        $admin->save();
        $admin->roles()->attach($role_admin);
    }
}
