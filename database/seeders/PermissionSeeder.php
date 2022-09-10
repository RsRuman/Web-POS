<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'Show',
            'slug' => 'show',
        ]);

        DB::table('permissions')->insert([
            'name' => 'Add',
            'slug' => 'add',
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit',
            'slug' => 'edit',
        ]);

        DB::table('permissions')->insert([
            'name' => 'Delete',
            'slug' => 'delete',
        ]);
    }
}
