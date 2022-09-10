<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone_no' => '01775742517',
            'is_verified' => User::IsVerified['Verified'],
            'status' => User::Status['Active'],
            'password' => Hash::make('12345678')
        ]);

        $admin = User::where('email', 'admin@admin.com')->first();

        $admin->roles()->attach(Role::where('slug', 'admin')->first());
        $admin->permissions()->sync([1,2,3,4]);
    }
}
