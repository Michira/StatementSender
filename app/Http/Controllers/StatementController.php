<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Controllers\Controller;

class StatementController extends Controller
{
    /**
     * Generate a statement and send email for a given client.
     *
     * @param  int  $id
     * @return View
     */
    public function generateStatement($id)
    {
        //Fetch all clients
        $clients = Client::all();
        dd($clients);

        if(count($issued_policies) == 0) {
            //No policies were issued yesterday
            Log::alert("No policies were issued yesterday");
        }
        else {

            foreach ($issued_policies as $key => $value) {
                $policy_no = $value->v_policy_no;
                $email = $value->email_no;//;
                $id = $value->id_no;
                $name = $value->cust_name;

                if($email == '' || $id == '') {
                    //Email or ID Number missing
                    Log::alert("Policy Number ".$policy_no." has missing ID or Email therefore mail not sent.");

                    DocumentFailed::firstOrCreate([
                        'policy_no' => $policy_no,
                        'email_address' => $email,
                        'status' => false,
                        'reason' => 'Email or ID Number is missing'
                    ]);

                    continue;
                }

                /******************************************************
                   Let's Validate the email address!
                *******************************************************/
                $res = $this->validate_email($email);

               

                    /******************************************************
                        We will need to check whether occupation code was 
                        captured so that we have no error sending emails
                    *******************************************************/

                    if(!is_null($data_pol_det) && isset($data_pol_det[0])){
                                    
                        $data = array('signature'=>$data_sign[0],
                                        'policy_no' => $policy_no,
                                        'pol_data' => $data_pol_det[0],
                                        'data_benefits' => $data_benefits,
                                        'definitions' => $data_definitions,
                                        'riders' => $riders);


                        /******************************************************
                           Check whether it is family shield and change the view that generates the PDF!
                        *******************************************************/

                        if (strpos($data_pol_det[0]->v_plan_code, 'FSC') === 0 ) {
                            $pdf = PDF::loadView('pdfs.family-shield',array('data' => $data));
                        }else {
                            //dd(strpos($data_pol_det[0]->v_plan_code, 'FSC'));
                            $pdf = PDF::loadView('pdfs.epolicy',array('data' => $data));
                        }
                        

                        $pdf->output();
                        $dom_pdf = $pdf->getDomPDF();

                        $canvas = $dom_pdf ->get_canvas();
                        $canvas->page_text(480, 760, "Page {PAGE_NUM}|{PAGE_COUNT}", null, 7, array(0, 0, 0));

                        // return $pdf->stream();

                        $canvas->get_cpdf()->setEncryption($id, "jubilee123");

                        $content = $pdf->download()->getOriginalContent();
                        
                        Storage::put('public/documents/outputs/'.$policy_no.'.pdf',$content) ;              


                        /******************************************************
                           This part sends emails with the normal mail sending tecnique using credentials set up in .env
                        *******************************************************/


                        // $emailresp = EmailHelper::send_policy_document(storage_path('app/public/documents/outputs/').$policy_no.'.pdf');


                        /******************************************************
                           This part sends emails with infobip APIs.
                        *******************************************************/
                        $emailresp = InfobipEmailHelper::sendEmail($policy_no, $email,$name);


                        /******************************************************
                           Let's save the email we have sent and generated document for.
                        *******************************************************/

                        if(isset($emailresp->messages[0]) && !is_null($emailresp->messages[0])){

                            DocumentSent::firstOrCreate([
                                'policy_no' => $policy_no,
                                'document_link' =>url('storage/documents/outputs/'.$policy_no.'.pdf'),
                                'email_address' => $email,
                                'date_sent' => date('Y-m-d H:i:s'),
                                'message_id' => $emailresp->messages[0]->messageId 
                            ]);

                        }
                    }
                    else {

                        DocumentFailed::firstOrCreate([
                            'policy_no' => $policy_no,
                            'email_address' => $email,
                            'status' => false,
                            'reason' => 'Has no occupation code set'
                        ]);
                        Log::alert("Policy Number ".$policy_no." has no occupation code set.");
                    }
                }
                else {

                    DocumentFailed::firstOrCreate([
                            'policy_no' => $policy_no,
                            'email_address' => $email,
                            'status' => false,
                            'reason' => 'Has an invalid Email Address'
                        ]);

                    Log::alert("Policy Number ".$policy_no." has an invalid Email Address ".$email." therefore mail not sent.");
                }
                
            }


        }

    }
}