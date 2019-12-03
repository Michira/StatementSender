<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Client;
use App\ClientProduct;
use App\Transaction;
use Carbon\Carbon;

class ClientProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = Client::all();

    	foreach ($clients as $key => $client) {
    		if ($client->id < 4) {
    			ClientProduct::firstOrCreate([
		            'client_id' => $client->id,
		            'product_id' => 1
		        ]);
		        ClientProduct::firstOrCreate([
		            'client_id' => $client->id,
		            'product_id' => 2
		        ]);
		        ClientProduct::firstOrCreate([
		            'client_id' => $client->id,
		            'product_id' => 3
		        ]);
    		}

    		if ($client->id > 3 && $client->id < 7) {
    			ClientProduct::firstOrCreate([
		            'client_id' => $client->id,
		            'product_id' => 4
		        ]);
		        ClientProduct::firstOrCreate([
		            'client_id' => $client->id,
		            'product_id' => 5
		        ]);
		        ClientProduct::firstOrCreate([
		            'client_id' => $client->id,
		            'product_id' => 6
		        ]);
    		}

    		if ($client->id > 7) {
    			ClientProduct::firstOrCreate([
		            'client_id' => $client->id,
		            'product_id' => 7
		        ]);
		        ClientProduct::firstOrCreate([
		            'client_id' => $client->id,
		            'product_id' => 8
		        ]);
		        ClientProduct::firstOrCreate([
		            'client_id' => $client->id,
		            'product_id' => 9
		        ]);

		        ClientProduct::firstOrCreate([
		            'client_id' => $client->id,
		            'product_id' => 10
		        ]);
    		}
    	}
    }
}
