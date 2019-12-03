<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Client;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i < 10; $i++) { 
    		Client::firstOrCreate([
	            'name' => Str::random(5).' '.Str::random(5),
	            'email' => 'mike.michira@gmail.com',
	            'phone' => '+254714222222',
	        ]);
    	}
        

    }
}
