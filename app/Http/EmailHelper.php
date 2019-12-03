<?php
/**
 * Created by PhpStorm.
 * User: brianondari
 * Date: 18/05/2018
 * Time: 14:24
 */

namespace App\Http;

use App\Modules\Common\Models\EmailToSend;
use App\Modules\Common\Models\FailedEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use App\User;

class EmailHelper
{
 
    static function send_statements($docData)
    {
        $subject = 'CLIENT STATEMENTS';
        $to = 'mike.michira@gmail.com';
        $name = 'Mike Michira';
		$type = 'Epolicy Doc';
        $data = [
            'name' => $name,
            'to' => $to,
            'subject' => $subject,
            'type' => $type,
            'cc' => 'mike.nyakundi@jubileekenya.com',
            'cc_name' => 'Mike Nyakundi'
            // 'bcc' => 'Dennis.Mwirigi@jubileekenya.com', # FOR TESTING
            // 'bcc_name' => 'Dennis Mwirigi', # FOR TESTING
        ];
        $template = "emails.statements";
        $attach = [
             'policy_doc' => $docData
        ];
        self::send_email($template, $data, $attach);
    }





    static function send_email($template, $data, $attach, $send_later = false)
    {
        Log::info('SEND_EMAIL: ' . json_encode($data));
        $message = View::make($template, $data)->render();
        if ($send_later) {
            EmailToSend::create([
                'type' => $data['type'],
                'message' => $message,
                'recipient' => $data['to'],
                'subject' => $data['subject'],
                'status' => 0,
                'user_id' => $data['u_id']
            ]);
        } else {
            $data['message'] = $message;
            $data['from'] = config('app.mail_from_address'); //env('MAIL_FROM_ADDRESS', 'marine@jubileeinsurance.com');
            $data['from_name'] = config('app.mail_from_name'); //env('MAIL_FROM_NAME', 'Jubilee Insurance');
            $data['attach'] = $attach;

            try {
                Mail::send($template, $data, function ($message) use ($data) {
                    $message->from($data['from'], $data['from_name']);
                    $message->to($data['to'], $data['name']);
                    if (isset($data['cc']) && !is_null($data['cc'])) {
                        $message->cc($data['cc'], $data['cc_name']);
                    }
                    if (isset($data['bcc']) && !is_null($data['bcc'])) {
                        $message->bcc($data['bcc'], $data['bcc_name']);
                    }
                    $message->subject($data['subject']);
                    if (!empty($data['attach'])) {
                        if (!empty($data['attach']['policy_doc'])) {
                            $message->attach($data['attach']['policy_doc'], [
                                'mime' => 'application/pdf',
                            ]);
                        }
                    }
                });

                if (Mail::failures()) {
                    Log::error('SEND_EMAIL_ERROR: mail error/failures');
                    // FailedEmail::create([
                    //     'type' => $data['type'],
                    //     'message' => $data['message'],
                    //     'recipient' => $data['to'],
                    //     'subject' => $data['subject'],
                    // ]);
                } else {
                    Log::error('SEND_EMAIL_SUCCESS: Mail Sent Successfully');
                    //echo "email sent";
                }

            } catch (\Swift_TransportException $e) {
                Log::error('SEND_EMAIL_Swift_TransportException: ' . json_encode($e->getMessage()));
                // FailedEmail::create([
                //     'type' => $data['type'],
                //     'message' => $data['message'],
                //     'recipient' => $data['to'],
                //     'subject' => $data['subject'],
                //     'error_message' => $e->getMessage()
                // ]);
            } catch (\Exception $e) {
                Log::error('SEND_EMAIL_Exception: ' . json_encode($e->getMessage()));
                // FailedEmail::create([
                //     'type' => $data['type'],
                //     'message' => $data['message'],
                //     'recipient' => $data['to'],
                //     'subject' => $data['subject'],
                //     'error_message' => json_encode($e->getMessage())
                // ]);
            }
        }
    }
}