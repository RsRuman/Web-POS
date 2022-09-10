<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Admin',
            'slug' => 'admin'
        ]);

        $admin = Role::where('slug', 'admin')->first();
        $admin->permissions()->sync([1,2,3,4]);

        DB::table('roles')->insert([
            'name' => 'Client',
            'slug' => 'client'
        ]);

        $client = Role::where('slug', 'client')->first();
        $client->permissions()->attach([1,2,3,4]);

        DB::table('roles')->insert([
            'name' => 'Manager',
            'slug' => 'manager'
        ]);

        $client = Role::where('slug', 'manager')->first();
        $client->permissions()->attach(1);
    }
}
