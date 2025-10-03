<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MpesaSdk\StkPush;
use App\Models\Booking;



class MpesaController extends Controller
{
    //
    public function mpesa($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        
        // Check if booking has an associated user
        if (!$booking->user) {
            return redirect()->back()->with('error', 'No user associated with this booking.');
        }
        
        // Check if user has a phone number
        if (!$booking->user->phonenumber) {
            return redirect()->back()->with('error', 'User phone number is required for payment.');
        }
        
        $stkpush = new StkPush();
        $phone_number = $booking->user->phonenumber;
        $phone_number = preg_replace('/\D/', '', $phone_number);

        if (substr($phone_number, 0, 1) === '0') {
            $phone_number = '254' . substr($phone_number, 1);
        }

        $amount = $booking->amount_to_pay;
        $reference = 'Mpesa Stk Push';
        $description = 'Payment for car booking';

        echo $stkpush->initiate($phone_number, $amount, $reference, $description);
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'mpesa_phone' => 'required',
            'amount' => 'required|numeric|min:1',
        ]);

        $phone_number = $request->mpesa_phone;
        $phone_number = preg_replace('/\D/', '', $phone_number);

        if (substr($phone_number, 0, 1) === '0') {
            $phone_number = '254' . substr($phone_number, 1);
        }

        $amount = $request->amount;
        $reference = 'Car Booking Payment';
        $description = 'Payment for car booking';

        try {
            $stkpush = new StkPush();
            $response = $stkpush->initiate($phone_number, $amount, $reference, $description);

            if ($response && strpos($response, 'Success') !== false) {
                return redirect()->back()->with('success', 'Payment prompt sent. Please complete payment on your phone.');
            } else {
                return redirect()->back()->with('error', 'Failed to initiate payment.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to initiate payment: ' . $e->getMessage());
        }
    }
}
