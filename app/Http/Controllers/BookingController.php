<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\MpesaService;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Book car per day
    public function bookCarPerDay(Request $request)
    {
        $request->validate([
            'total_days' => 'required|integer|min:1',
            'car_id' => 'required|exists:cars,id',
            'user_id' => 'required|exists:users,id',
            'rate_per_day' => 'required|numeric|min:0',
        ]);

        $amount_to_pay = $request->total_days * $request->rate_per_day;

        $bookingData = [
            'car_id' => $request->car_id,
            'user_id' => $request->user_id,
            'total_days' => $request->total_days,
            'amount_to_pay' => $amount_to_pay,
            'booking_status' => 'active',
        ];

        $create = Booking::create($bookingData);

        if ($create) {
            alert()->success('Success', 'Car Booked successfully! Please complete your payment.');
            return redirect()->route('customerBookings');
        } else {
            alert()->error('Error', 'Failed to Book Car.');
            return redirect()->back();
        }
    }

    // Book car per km
    public function bookCarPerKm(Request $request)
    {
        $request->validate([
            'total_km' => 'required|integer|min:1',
            'car_id' => 'required|exists:cars,id',
            'user_id' => 'required|exists:users,id',
            'rate_per_km' => 'required|numeric|min:0',
        ]);

        $amount_to_pay = $request->total_km * $request->rate_per_km;

        $bookingData = [
            'car_id' => $request->car_id,
            'user_id' => $request->user_id,
            'total_km' => $request->total_km,
            'amount_to_pay' => $amount_to_pay,
            'booking_status' => 'active',
        ];

        $create = Booking::create($bookingData);

        if ($create) {
            alert()->success('Success', 'Car Booked successfully! Please complete your payment.');
            return redirect()->route('customerBookings');
        } else {
            alert()->error('Error', 'Failed to Book Car.');
            return redirect()->back();
        }
    }

    // List bookings for the customer
    public function customerBookings()
    {
        $bookedCars = Booking::where('user_id', Auth::user()->id)->get();
        return view('cars.customerBookings', compact('bookedCars'));
    }

    // Delete a booking
    public function destroy($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->delete();

        alert()->success('Success', 'Booking deleted successfully.');
        return redirect()->route('allBookings');
    }

    // Return a car
    public function returnCar(Request $request, $bookingId)
    {
        $request->validate([
            'return_date' => 'required|date',
            'return_time' => 'required',
        ]);

        $booking = Booking::findOrFail($bookingId);

        $booking->booking_status = 'returned';
        $booking->return_status = 'returned';
        $booking->return_date = $request->return_date;
        $booking->return_time = $request->return_time;
        $booking->save();

        alert()->success('Success', 'Car returned successfully. The car is now available for booking again.');
        return redirect()->route('carListings');
    }

    public function redirectToPaymentPagePerDay(Request $request)
    {
        // Validate required fields
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'user_id' => 'required|exists:users,id',
            'total_days' => 'required|integer|min:1',
            'rate_per_day' => 'required|numeric|min:0',
        ]);

        // Calculate amount
        $amount_to_pay = $request->total_days * $request->rate_per_day;

        // Create booking in the database
        $booking = \App\Models\Booking::create([
            'car_id' => $request->car_id,
            'user_id' => $request->user_id,
            'total_days' => $request->total_days,
            'amount_to_pay' => $amount_to_pay,
            'booking_status' => 'active',
            'payment_status' => 'Pending',
        ]);

        // Get car information (for the view)
        $car = \App\Models\Car::find($request->car_id);
        $booking->car = $car;

        // Pass booking object to the payment view
        return view('payments.process-payment', compact('booking'));
    }

    public function redirectToPaymentPagePerKm(Request $request)
    {
        // Validate required fields
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'user_id' => 'required|exists:users,id',
            'total_km' => 'required|integer|min:1',
            'rate_per_km' => 'required|numeric|min:0',
        ]);

        // Calculate amount
        $amount_to_pay = $request->total_km * $request->rate_per_km;

        // Create booking in the database
        $booking = \App\Models\Booking::create([
            'car_id' => $request->car_id,
            'user_id' => $request->user_id,
            'total_km' => $request->total_km,
            'amount_to_pay' => $amount_to_pay,
            'booking_status' => 'active',
            'payment_status' => 'Pending',
        ]);

        // Get car information (for the view)
        $car = \App\Models\Car::find($request->car_id);
        $booking->car = $car;

        // Pass booking object to the payment view
        return view('payments.process-payment', compact('booking'));
    }

    public function processPayment(Request $request)
    {
        $phone = $request->input('mpesa_phone');
        $amount = $request->input('amount');
        $bookingId = $request->input('booking_id');

        // Validate phone and amount
        $phone = preg_replace('/^(\+254|254|0)/', '254', $phone);
        $phone = preg_replace('/\s+/', '', $phone); // Remove spaces

        if (!preg_match('/^2547\d{8}$/', $phone)) {
            return redirect()->back()->with('error', 'Invalid phone number format. Use 07XXXXXXXX.');
        }

        if (!is_numeric($amount) || $amount < 1) {
            return redirect()->back()->with('error', 'Invalid amount.');
        }

        // Daraja credentials from .env
        $consumerKey = config('services.mpesa.consumer_key');
        $consumerSecret = config('services.mpesa.consumer_secret');
        $shortCode = config('services.mpesa.short_code');
        $passkey = config('services.mpesa.passkey');
        $callbackUrl = route('mpesa.callback');

        $timestamp = date('YmdHis');
        $password = base64_encode($shortCode . $passkey . $timestamp);

        try {
            // Get access token
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials', [
                'auth' => [$consumerKey, $consumerSecret]
            ]);
            $accessToken = json_decode($response->getBody())->access_token;

            // Initiate STK Push
            $stkPushData = [
                "BusinessShortCode" => $shortCode,
                "Password" => $password,
                "Timestamp" => $timestamp,
                "TransactionType" => "CustomerPayBillOnline",
                "Amount" => (int)$amount,
                "PartyA" => $phone,
                "PartyB" => $shortCode,
                "PhoneNumber" => $phone,
                "CallBackURL" => $callbackUrl,
                "AccountReference" => "CarHire",
                "TransactionDesc" => "Car Hire Payment"
            ];

            // Log request for debugging
            Log::info('STK Push Request:', $stkPushData);

            $stkResponse = $client->request('POST', 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($stkPushData)
            ]);

            $result = json_decode($stkResponse->getBody(), true);

            // Log response for debugging
            Log::info('STK Push Response:', $result);

            if (isset($result['ResponseCode']) && $result['ResponseCode'] == '0') {
                return redirect()->back()->with('success', 'Payment prompt sent. Please complete payment on your phone.');
            } else {
                $errorMsg = $result['errorMessage'] ?? 'Failed to initiate payment. Try again.';
                return redirect()->back()->with('error', $errorMsg);
            }
        } catch (\Exception $e) {
            Log::error('STK Push Exception:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Payment request failed. Please try again later.');
        }
    }

            public function PaymentPage($bookingId)
        {
            $booking = \App\Models\Booking::with('car.carModel')->findOrFail($bookingId);
            return view('payments.process-payment', compact('booking'));
        }

       
        public function allBookings()
        {            
            $bookedCars = Booking::with(['car.carModel', 'user'])->get();           
            return view('cars.allBookings', compact('bookedCars'));
        }



}
