<?php

namespace App\Http\Controllers;

use App\Client;
use App\Product;
use App\ClientProduct;
use App\Transaction;
use App\Http\Controllers\Controller;
use PDF;
use Storage;
use App\Http\EmailHelper;

class StatementController extends Controller
{
    /**
     * Generate a statement and send email for a given client.
     *
     * @return View
     */
    public function generateStatement()
    {
        //Fetch all clients
        $clients = Client::with('products')->get();
       

        if(count($clients) == 0) {
            //No clients to send statements to
            Log::alert("No clients available");
        }
        else {
            //Let us loop through the clients and get their transactions per product
            foreach ($clients as $key => $client) {

                $client_prods = ClientProduct::where('client_id',$client->id)->get();

                $client_transactions = [];
                foreach ($client_prods as $key => $prod) {
                   
                    $transactions = Transaction::where('prod_id',$prod->id)->get();

                    $client_transactions[] = array(
                        'product' => Product::find($prod->product_id)->name,
                        'transactions' => $transactions);
                }

                //Let's generate a PDF Statement
                $pdf = PDF::loadView('statement',array('client_trans' => $client_transactions));
                        

                $pdf->output();

                $content = $pdf->download()->getOriginalContent();
                        
                Storage::put('public/documents/outputs/statement '.$client->id.'.pdf',$content) ;              


                $emailresp = EmailHelper::send_statements(storage_path('app/public/documents/outputs/statement ').$client->id.'.pdf');

                Log::info("Statement for client ".$client->id." sent successfully");     
            }              
                
        }
    }

}