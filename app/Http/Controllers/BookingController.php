<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\MpesaService;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function bookCarPerDay(Request $request)
    {
        $amount_to_pay = $request->total_days * $request->rate_per_day;
        $create = Booking::create([
            'car_id' => $request->car_id,
            'user_id' => $request->user_id,
            'total_days' => $request->total_days,
            'amount_to_pay' => $amount_to_pay,
            'status' => 'active', // Set status to active
        ]);

        if ($create) {
            alert()->success('Success', 'Car Booked successfully.');

            return redirect()->back();
        } else {
            alert()->error('Error', 'Failed to Book Car.');

            return redirect()->back();
        }
    }

    public function bookCarPerKm(Request $request)
    {
        $amount_to_pay = $request->total_km * $request->rate_per_km;
        $create = Booking::create([
            'car_id' => $request->car_id,
            'user_id' => $request->user_id,
            'total_km' => $request->total_km,
            'amount_to_pay' => $amount_to_pay,
            'status' => 'active', // Set status to active
        ]);

        if ($create) {
            alert()->success('Success', 'Car Booked successfully.');

            return redirect()->back();
        } else {
            alert()->error('Error', 'Failed to Book Car.');

            return redirect()->back();
        }
    }

    public function customerBookings()
    {
        $bookedCars = Booking::where('user_id', Auth::user()->id)->get();
        return view('cars.customerBookings', compact('bookedCars'));
    }

    public function makePayment(Request $request, $bookingId)
    {
        $request->validate([
            'payment_method' => 'required|in:mpesa',
            'transaction_reference' => 'required|string',
        ]);

        $booking = Booking::findOrFail($bookingId);
        
        // If payment method is M-Pesa, initiate STK push
        if ($request->payment_method === 'mpesa') {
            $mpesaService = new MpesaService();
            
            $phoneNumber = $request->transaction_reference; // Using transaction_reference field for phone number
            $amount = $booking->amount_to_pay;
            $reference = 'BOOKING_' . $booking->id;
            
            $response = $mpesaService->initiateSTKPush($phoneNumber, $amount, $reference);
            
            if (isset($response['CheckoutRequestID'])) {
                // Store pending payment details
                $booking->payment_method = 'mpesa';
                $booking->transaction_reference = $phoneNumber;
                $booking->checkout_request_id = $response['CheckoutRequestID'];
                $booking->payment_status = 'Pending';
                $booking->save();
                
                alert()->success('Payment Initiated', 'Please check your phone for M-Pesa payment prompt. Enter your PIN to complete the payment.');
            } else {
                alert()->error('Payment Failed', 'Failed to initiate M-Pesa payment. Please try again.');
            }
        } else {
            // For other payment methods (fallback)
            $booking->payment_status = 'Paid';
            $booking->payment_method = $request->payment_method;
            $booking->transaction_reference = $request->transaction_reference;
            $booking->save();
            
            alert()->success('Success', 'Payment made successfully.');
        }

        return redirect()->route('customerBookings');
    }

    public function downloadReceipt($bookingId)
    {
        $filePath = public_path('receipts/receipt_' . $bookingId . '.pdf');
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            alert()->error('Error', 'Receipt not found.');
            return redirect()->back();
        }
    }

    public function destroy($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->delete();

        alert()->success('Success', 'Booking deleted successfully.');
        return redirect()->route('customerBookings');
    }

    public function makePaymentAll(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:mpesa',
            'transaction_reference' => 'required|string',
            'total_amount' => 'required|numeric|min:1',
        ]);

        $bookings = Booking::where('user_id', Auth::user()->id)
                          ->where('payment_status', '!=', 'Paid')
                          ->get();

        if ($bookings->isEmpty()) {
            alert()->error('Error', 'No pending payments found.');
            return redirect()->route('customerBookings');
        }

        // If payment method is M-Pesa, initiate STK push for total amount
        if ($request->payment_method === 'mpesa') {
            $mpesaService = new MpesaService();
            
            $phoneNumber = $request->transaction_reference;
            $amount = $request->total_amount;
            $reference = 'BULK_PAYMENT_' . Auth::user()->id . '_' . time();
            
            $response = $mpesaService->initiateSTKPush($phoneNumber, $amount, $reference);
            
            if (isset($response['CheckoutRequestID'])) {
                // Store pending payment details for all bookings
                foreach ($bookings as $booking) {
                    $booking->payment_method = 'mpesa';
                    $booking->transaction_reference = $phoneNumber;
                    $booking->checkout_request_id = $response['CheckoutRequestID'];
                    $booking->payment_status = 'Pending';
                    $booking->save();
                }
                
                alert()->success('Payment Initiated', 'Please check your phone for M-Pesa payment prompt. Enter your PIN to complete the payment for all bookings.');
            } else {
                alert()->error('Payment Failed', 'Failed to initiate M-Pesa payment. Please try again.');
            }
        } else {
            // For other payment methods (fallback)
            foreach ($bookings as $booking) {
                $booking->payment_status = 'Paid';
                $booking->payment_method = $request->payment_method;
                $booking->transaction_reference = $request->transaction_reference;
                $booking->save();
            }
            
            alert()->success('Success', 'Payments made successfully.');
        }

        return redirect()->route('customerBookings');
    }

    // Add this method to handle returning a car
    public function returnCar($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->return_status = 'returned';
        $booking->save();

        alert()->success('Success', 'Car returned successfully.');
        return redirect()->route('customerBookings');
    }

    // M-Pesa callback method to handle payment confirmations
    // public function mpesaCallback(Request $request)
    // {
    //     $mpesaService = new MpesaService();
    //     $callbackData = $request->all();
        
    //     $result = $mpesaService->handleCallback($callbackData);
        
    //     if ($result['success']) {
    //         // Payment was successful
    //         $checkoutRequestID = $result['checkout_request_id'];
            
    //         // Find bookings with this checkout request ID and mark them as paid
    //         $bookings = Booking::where('checkout_request_id', $checkoutRequestID)
    //                           ->where('payment_status', 'Pending')
    //                           ->get();
            
    //         foreach ($bookings as $booking) {
    //             $booking->payment_status = 'Paid';
    //             $booking->mpesa_receipt_number = $result['mpesa_receipt_number'] ?? null;
    //             $booking->transaction_date = $result['transaction_date'] ?? null;
    //             $booking->save();
    //         }
            
    //         Log::info('M-Pesa payment successful', [
    //             'checkout_request_id' => $checkoutRequestID,
    //             'bookings_updated' => $bookings->count(),
    //             'mpesa_receipt' => $result['mpesa_receipt_number']
    //         ]);
    //     } else {
    //         // Payment failed
    //         $checkoutRequestID = $result['checkout_request_id'];
            
    //         // Find bookings with this checkout request ID and mark them as failed
    //         $bookings = Booking::where('checkout_request_id', $checkoutRequestID)
    //                           ->where('payment_status', 'Pending')
    //                           ->get();
            
    //         foreach ($bookings as $booking) {
    //             $booking->payment_status = 'Failed';
    //             $booking->save();
    //         }
            
    //         Log::error('M-Pesa payment failed', [
    //             'checkout_request_id' => $checkoutRequestID,
    //             'result_desc' => $result['result_desc']
    //         ]);
    //     }
        
    //     // Return success response to M-Pesa
    //     return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
    // }
}
