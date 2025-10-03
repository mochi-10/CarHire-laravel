@extends('layouts.frontend')

@section('content')
<div class="hero inner-page" style="background-image: url('frontend/images/hero_1_a.jpg');">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-lg-5">
                <div class="intro">
                    <h1><strong>Process Payment</strong></h1>
                    <div class="custom-breadcrumbs">
                        <a href="{{route('welcome')}}">Home</a> 
                        <span class="mx-2">/</span> 
                        <a href="{{route('customerBookings')}}">My Bookings</a>
                        <span class="mx-2">/</span> 
                        <strong>Process Payment</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="site-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Payment Details</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if($booking)
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5>Booking Information</h5>
                                    <ul class="list-unstyled">
                                        @if($booking->id !== 'pending')
                                            <li><strong>Booking ID:</strong> #{{ $booking->id }}</li>
                                        @endif
                                        <li><strong>Car:</strong> {{ $booking->car->make }} {{ $booking->car->carModel->name ?? '' }}</li>
                                        <li><strong>Registration:</strong> {{ $booking->car->registration_number }}</li>
                                        @if(isset($booking->total_days))
                                            <li><strong>Duration:</strong> {{ $booking->total_days }} day(s)</li>
                                        @endif
                                        @if(isset($booking->total_km))
                                            <li><strong>Distance:</strong> {{ $booking->total_km }} km</li>
                                        @endif
                                        @if(isset($booking->rate_per_day))
                                            <li><strong>Rate per Day:</strong> Ksh {{ number_format($booking->rate_per_day, 2) }}</li>
                                        @endif
                                        @if(isset($booking->rate_per_km))
                                            <li><strong>Rate per Km:</strong> Ksh {{ number_format($booking->rate_per_km, 2) }}</li>
                                        @endif
                                        <li><strong>Amount:</strong> Ksh {{ number_format($booking->amount_to_pay, 2) }}</li>
                                        @if($booking->id !== 'pending')
                                            <li><strong>Status:</strong> 
                                                <span class="badge badge-{{ $booking->payment_status === 'Paid' ? 'success' : ($booking->payment_status === 'Pending' ? 'warning' : 'danger') }}">
                                                    {{ $booking->payment_status }}
                                                </span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    @if($booking->car->image)
                                        <img src="{{ asset('images/' . $booking->car->image) }}" alt="Car Image" class="img-fluid rounded" style="max-height:200px; object-fit:cover;">
                                    @endif
                                </div>
                            </div>

                            @if($booking->id === 'pending' || $booking->payment_status !== 'Paid')
                                <form method="POST" action="{{ route('processPayment') }}" id="paymentForm">
                                    @csrf
                                    @if($booking->id === 'pending')
                                        <input type="hidden" name="car_id" value="{{ $booking->car_id }}">
                                        <input type="hidden" name="user_id" value="{{ $booking->user_id }}">
                                        @if(isset($booking->total_days))
                                            <input type="hidden" name="total_days" value="{{ $booking->total_days }}">
                                            <input type="hidden" name="rate_per_day" value="{{ $booking->rate_per_day }}">
                                        @endif
                                        @if(isset($booking->total_km))
                                            <input type="hidden" name="total_km" value="{{ $booking->total_km }}">
                                            <input type="hidden" name="rate_per_km" value="{{ $booking->rate_per_km }}">
                                        @endif
                                        <input type="hidden" name="amount" value="{{ $booking->amount_to_pay }}">
                                    @else
                                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                        <input type="hidden" name="amount" value="{{ $booking->amount_to_pay }}">
                                    @endif
                                    
                                    <div class="form-group">
                                        <label>Payment Method</label>
                                        <select class="form-control" id="payment_method" name="payment_method" required>
                                            <option value="">Select Payment Method</option>
                                            <option value="mpesa">M-Pesa</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="mpesa_phone">M-Pesa Phone Number</label>
                                        <input type="text" class="form-control" name="mpesa_phone" id="mpesa_phone" required placeholder="07XXXXXXXX">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Amount to Pay</label>
                                        <div class="form-control bg-light" style="font-weight: bold; color: #007bff;">
                                            Ksh {{ number_format($booking->amount_to_pay, 2) }}
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-info">
                                        <strong>Payment Instructions:</strong>
                                        <ul class="mb-0 mt-2">
                                            <li>Click "Process Payment" to initiate M-Pesa payment</li>
                                            <li>You will receive a payment prompt on your phone</li>
                                            <li>Enter your M-Pesa PIN to complete the payment</li>
                                            <li>Payment status will be updated automatically</li>
                                        </ul>
                                    </div>
                                    
                                    <!-- <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            <i class="fa fa-credit-card"></i> Process Payment - Ksh {{ number_format($booking->amount_to_pay, 2) }}
                                        </button>
                                    </div> -->
                                    <a href="{{ route('mpesa', ['bookingId' => $booking->id]) }}" class="btn btn-success btn-lg btn-block">
                                        <i class="fa fa-mobile"></i> Pay with Mpesa - Ksh {{ number_format($booking->amount_to_pay, 2) }}
                                    </a>
                                </form>
                            @else
                                <div class="alert alert-success">
                                    <h5><i class="fa fa-check-circle"></i> Payment Completed</h5>
                                    <p>This booking has already been paid. Payment status: <strong>Paid</strong></p>
                                    @if($booking->mpesa_receipt_number)
                                        <p><strong>M-Pesa Receipt:</strong> {{ $booking->mpesa_receipt_number }}</p>
                                    @endif
                                </div>
                                
                                <div class="text-center">
                                    <a href="{{ route('customerBookings') }}" class="btn btn-secondary">
                                        <i class="fa fa-arrow-left"></i> Back to My Bookings
                                    </a>
                                    <a href="{{ route('downloadReceipt', $booking->id) }}" class="btn btn-success">
                                        <i class="fa fa-download"></i> Download Receipt
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-danger">
                                <h5><i class="fa fa-exclamation-triangle"></i> Booking Not Found</h5>
                                <p>The booking you're looking for doesn't exist or you don't have permission to access it.</p>
                            </div>
                            
                            <div class="text-center">
                                <a href="{{ route('customerBookings') }}" class="btn btn-primary">
                                    <i class="fa fa-arrow-left"></i> Back to My Bookings
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection