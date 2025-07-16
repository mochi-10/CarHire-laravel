<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

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
        $booking = Booking::findOrFail($bookingId);
        $booking->payment_status = 'Paid';
        $booking->save();

        alert()->success('Success', 'Payment made successfully.');

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
        $bookingIds = $request->input('booking_ids');
        $bookings = Booking::whereIn('id', $bookingIds)->get();

        foreach ($bookings as $booking) {
            $booking->payment_status = 'Paid';
            $booking->save();
        }

        alert()->success('Success', 'Payments made successfully.');
        return redirect()->route('customerBookings');
    }
}
