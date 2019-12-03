<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\ClientProduct;
use App\Transaction;
use Carbon\Carbon;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$clientProducts = ClientProduct::all();

    	foreach ($clientProducts as $key => $clientProduct) {

    		for ($i=0; $i < 5; $i++) { 
	    		Transaction::firstOrCreate([
		            'trans_type' => 'd',
		            'client_prod_id' => $clientProduct->id,
		            'trans_amount' => rand(1000,200000),
		            'trans_date' => Carbon::now(),
		        ]);
	    	}


	    	for ($i=0; $i < 5; $i++) { 
	    		Transaction::firstOrCreate([
		            'trans_type' => 'w',
		            'client_prod_id' => $clientProduct->id,
		            'trans_amount' => rand(1000,100000),
		            'trans_date' => Carbon::now(),
		        ]);
	    	}
    	}
        
    }
}
