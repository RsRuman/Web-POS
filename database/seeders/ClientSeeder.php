<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Client',
            'email' => 'client@client.com',
            'phone_no' => '01550076692',
            'is_verified' => User::IsVerified['Verified'],
            'status' => User::Status['Active'],
            'password' => Hash::make('12345678')
        ]);

        $admin = User::where('email', 'client@client.com')->first();

        $admin->roles()->attach(Role::where('slug', 'client')->first());
        $admin->permissions()->sync([1,2,3,4]);
    }
}
