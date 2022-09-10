<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = Str::random(10);
        DB::table('users')->insert([
            'name' => $name,
            'email' => $name.'@email.com',
            'password' => Hash::make('password')
        ]);

        $user = User::where('email', '!=', 'admin@admin.com')->first();

        $user->roles()->attach(Role::where('slug', 'user')->first());
        $user->permissions()->attach(Role::where('slug', 'show')->first());
    }
}
