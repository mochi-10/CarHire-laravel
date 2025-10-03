@extends('layouts.frontend')

@section('content')
<div class="hero inner-page" style="background-image: url('frontend/images/hero_1_a.jpg');">
  <div class="container">
    <div class="row align-items-end ">
      <div class="col-lg-5">
        <div class="intro">
          <h1><strong>My Bookings</strong></h1>
          <div class="custom-breadcrumbs"><a href="{{route('welcome')}}">Home</a> <span class="mx-2">/</span> <strong>My Bookings</strong></div>
        </div>
      </div>
    </div>
    <div class="site-section">
      <div class="container">
        <div class="row">

          <table class="table table-sm table-bordered table-striped table-responsive">
            <thead>
              <th>#</th>
              <th>Car Image</th>
              <th>Car Model</th>
              <th>Total days</th>
              <th>Total KM</th>
              <th>Rate Per Day</th>
              <th>Rate Per KM</th>
              <th>Booking Status</th>
              <th>Amount to Pay</th>
              <th>Payment Status</th>
              <th>Return Status</th>
              @if(Auth::check() && Auth::user()->role === 'Admin')
                <th>Action</th>
              @endif
            </thead>
            <tbody>
              @if($bookedCars && count($bookedCars))
                @foreach($bookedCars as $index => $booking)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                      @if($booking->car && $booking->car->image)
                        <img src="{{ asset('images/' . $booking->car->image) }}" alt="Car Image" class="img-fluid rounded" style="max-height:100px; object-fit:cover;">
                      @else
                        <p>No image available</p>
                      @endif
                    </td>
                    <td>
                      @if($booking->car)
                        {{ $booking->car->carModel->name ?? '' }}
                      @else
                        [Car not found]
                      @endif
                    </td>
                    <td>{{ $booking->total_days }}</td>
                    <td>{{ $booking->total_km }}</td>
                    <td>
                      @if($booking->car)
                        Ksh.{{ $booking->car->rate_per_day }}
                      @else
                        -
                      @endif
                    </td>
                    <td>
                      @if($booking->car)
                        Ksh.{{ $booking->car->rate_per_km }}
                      @else
                        -
                      @endif
                    </td>
                    <td>
                      @if($booking->booking_status === 'active')
                        <span class="badge badge-success">Active</span>
                      @elseif($booking->booking_status === 'returned')
                        <span class="badge badge-secondary">Returned</span>
                      @else
                        <span class="badge badge-light">{{ ucfirst($booking->booking_status) }}</span>
                      @endif
                    </td>
                    <td>Ksh.{{ $booking->amount_to_pay }}</td>
                    <td>
                      @if($booking->payment_status === 'Paid')
                        <span class="badge badge-success">Paid</span>
                      @else
                        <span class="badge badge-warning">Pending</span>
                        <a href="{{ route('PaymentPage', ['booking' => $booking->id]) }}" class="badge badge-primary ml-2 blinking-pay">
                          Pay
                        </a>
                      @endif
                    </td>
                    <td>
                      @if($booking->return_status === 'returned')
                        <span class="badge badge-success">Returned</span>
                      @else
                        <span class="badge badge-warning">Pending</span>
                      @endif
                    </td>
                    @if(Auth::check() && Auth::user()->role === 'Admin')
                    <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-cogs"></i> More Action <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu p-2" role="menu" style="min-width: 180px;">
                          <li class="dropdown-header text-center font-weight-bold">More Action</li>
                          <li class="divider"></li>
                          <li>
                            <a href="#" class="text-warning" data-toggle="modal" data-target="#returnCarModal{{ $booking->id }}">
                              <i class="fa fa-carriage-return"></i>Return Car
                            </a>
                          </li>
                          <li>
                            <a href="#" class="text-danger" data-toggle="modal" data-target="#deleteModal{{ $booking->id }}">
                              <i class="fa fa-delete"></i>Delete
                            </a>
                          </li>
                          <li class="divider"></li>
                        </ul>
                      </div>
                    </td>
                    @endif
                  </tr>

                  <!-- Return Car Modal -->
                  <div class="modal fade" id="returnCarModal{{ $booking->id }}" tabindex="-1" role="dialog" aria-labelledby="returnCarModalLabel{{ $booking->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <form method="POST" action="{{ route('returnCar', $booking->id) }}">
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="returnCarModalLabel{{ $booking->id }}">Return Car</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p>Are you sure you want to return this car?</p>
                            <div class="form-group">
                              <label>Return Date</label>
                              <input type="date" class="form-control" name="return_date" required>
                            </div>
                            <div class="form-group">
                              <label>Return Time</label>
                              <input type="time" class="form-control" name="return_time" required>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Return Car</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                  <!-- Payment Modal -->
                  <div class="modal fade" id="paymentModal{{ $booking->id }}" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel{{ $booking->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <form method="POST" action="{{ route('makePayment', $booking->id) }}">
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="paymentModalLabel{{ $booking->id }}">Make Payment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="form-group">
                              <label>Amount to Pay</label>
                              <input type="number" class="form-control" name="amount" value="{{ $booking->amount_to_pay }}" readonly>
                            </div>
                            <div class="form-group">
                              <label>Payment Method</label>
                              <select class="form-control" name="payment_method" required>
                                <option value="">Select Method</option>
                                <option value="mpesa">M-Pesa</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label>Mpesa Number</label>
                              <input type="text" class="form-control" name="transaction_reference" placeholder="Enter Mpesa Number" required>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Pay Now</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                  <!-- Delete Modal -->
                  <div class="modal fade" id="deleteModal{{ $booking->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $booking->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <form method="POST" action="{{ route('deleteBooking', $booking->id) }}">
                        @csrf
                        @method('POST')
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel{{ $booking->id }}">Delete Booking</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p>Are you sure you want to delete this booking?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" style="color: white;">Delete</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <!--end Delete Modal-->
                @endforeach
              @else
                <tr>
                  <td colspan="12" class="text-center">No bookings found.</td>
                </tr>
              @endif
            </tbody>
          </table>

          @php
            $totalAmount = $bookedCars && count($bookedCars) ? $bookedCars->sum('amount_to_pay') : 0;
          @endphp

          <!-- Pay All Modal -->
          <div class="modal fade" id="payAllModal" tabindex="-1" role="dialog" aria-labelledby="payAllModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <form method="POST" action="{{ route('makePaymentAll') }}">
                @csrf
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="payAllModalLabel">Pay All Bookings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label>Total Amount to Pay</label>
                      <input type="number" class="form-control" name="total_amount" value="{{ $totalAmount }}" readonly>
                    </div>
                    <div class="form-group">
                      <label>Payment Method</label>
                      <select class="form-control" name="payment_method" required>
                        <option value="">Select Method</option>
                        <option value="mpesa">M-Pesa</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Mpesa Number</label>
                      <input type="text" class="form-control" name="transaction_reference" placeholder="Enter Mpesa Number" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Pay Now</button>
                  </div>
                </div>
              </form>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection

<!-- Add this in your <head> section or at the top of your Blade file -->
<style>
.blinking-pay {
    animation: blinker 1s linear infinite;
}
@keyframes blinker {
    50% { opacity: 0; }
}
</style>