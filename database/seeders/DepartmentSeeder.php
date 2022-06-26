<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	foreach (['Admin', 'HR', 'Accounts', 'Sales'] as $name) {
	        DB::table('departments')->insert([
	            'name' 			=> $name,
	            'is_active' 	=> 1,
	            'created_at' 	=> now(),
	            'updated_at' 	=> now(),
	        ]);
	    }
    }
}
