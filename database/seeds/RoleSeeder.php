<?php

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
            ['name' => 'admin', 'description' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'author', 'description' => 'Author', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'reader', 'description' => 'Reader', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
