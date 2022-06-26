<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (['Administrator', 'Manager', 'Assistant', 'Developer'] as $name) {
	        DB::table('roles')->insert([
	            'name' 			=> $name,
	            'is_active' 	=> 1,
	            'created_at' 	=> now(),
	            'updated_at' 	=> now(),
	        ]);
	    }
    }
}
