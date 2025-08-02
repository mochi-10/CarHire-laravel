<?php

namespace App\Http\Controllers;
use AfricasTalking\SDK\AfricasTalking;

use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function sms()
    {
        $username = 'carhire'; // use 'sandbox' for development in the test environment
        $apiKey   = 'atsk_99491c8267b523b1296512af7b1fa0465d0cee0b1a1a3543143b0505133f62e998b4165f'; // use your sandbox app API key for development in the test environment
        $AT       = new AfricasTalking($username, $apiKey);

        // Get one of the services
        $sms      = $AT->sms();

        // Use the service
        $result   = $sms->send([
            'to'      => '+254712613928',
            'message' => 'Hello World!'
        ]);

        print_r($result);
    }
}
