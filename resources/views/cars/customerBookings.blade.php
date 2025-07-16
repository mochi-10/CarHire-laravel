@extends('layouts.frontend')

@section('content')
<div class="hero inner-page" style="background-image: url('frontend/images/hero_1_a.jpg');">
  <div class="container">
    <div class="row align-items-end ">
      <div class="col-lg-5">
        <div class="intro">
          <h1><strong>My Bookings</strong></h1>
          <div class="custom-breadcrumbs"><a href="{{route('home')}}">Home</a> <span class="mx-2">/</span> <strong>My Bookings</strong></div>
        </div>
      </div>
    </div>
    <div class="site-section">
      <div class="container">
        <div class="row">

          <table class="table table-sm table-bordered table-striped">
            <thead>
              <th>#</th>
              <th>Car Image</th>
              <th>Car Model</th>
              <th>Total days</th>
              <th>Total KM</th>
              <th>Rate Per Day</th>
              <th>Rate Per KM</th>
              <th>Amount to Pay</th>
              <th>Action</th>
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
                <td>Ksh.{{ $booking->amount_to_pay }}</td>

                <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-cogs"></i> More Action <span class="caret"></span></button>
                    <ul class="dropdown-menu p-2" role="menu" style="min-width: 180px;">
                      <li class="dropdown-header text-center font-weight-bold">More Action</li>
                      <li class="divider"></li>
                      <li>
                        <a href="#" class="text-primary" data-toggle="modal" data-target="#paymentModal{{ $booking->id }}">
                          <i class="fa fa-credit-card"></i>Make Payment
                        </a>
                      </li>
                      <li class="divider"></li>
                    
                      @if(Auth::check() && Auth::user()->role === 'Admin')
                      <li>
                        <a href="#" class="text-danger" data-toggle="modal" data-target="#deleteModal{{ $booking->id }}">
                          <i class="fa fa-delete"></i>Delete
                        </a>
                      </li>
                      @else
                      

                      {{-- The delete button is now only visible to admins --}}
                      @endif

                      <li class="divider"></li>
                      <!-- <li>
                                    <a href="#" class="dropdown-item text-primary" data-toggle="modal" data-target="#receiptModal{{ $booking->id }}">
                                    <i class="fa fa-download mr-2"></i>Download Receipt
                                    </a>
                                    </li> -->

                    </ul>
                  </div>
                </td>
              </tr>

              <!-- Payment Modal -->
              <div class="modal fade" id="paymentModal{{ $booking->id }}" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel{{ $booking->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form method="POST" action="{{ route('makePayment', $booking->id) }}">
                    @csrf
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel{{ $booking->id }}">Make Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        </button>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
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

              <!--Receipt Modal
                        <div class="modal fade" id="receiptModal{{ $booking->id }}" tabindex="-1" role="dialog" aria-labelledby="receiptModalLabel{{ $booking->id }}" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="receiptModalLabel{{ $booking->id }}">Payment Receipt</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p><strong>Booking ID:</strong> {{ $booking->id }}</p>
                                <p><strong>Car:</strong> {{ $booking->car->make ?? '' }} {{ $booking->car->carModel->name ?? '' }}</p>
                                <p><strong>Amount Paid:</strong> Ksh.{{ $booking->amount_to_pay }}</p>
                                <p><strong>Payment Method:</strong> {{ $booking->payment_method ?? '-' }}</p>
                                <p><strong>Transaction Reference:</strong> {{ $booking->transaction_reference ?? '-' }}</p>
                                <p><strong>Date:</strong> {{ $booking->updated_at->format('d M Y, H:i') }}</p>
                                <hr>
                                <a href="{{ route('downloadReceipt', $booking->id) }}" class="btn btn-primary" target="_blank">
                                  <i class="fa fa-download"></i> Download Receipt (PDF)
                                </a>

                              </div>
                            </div>
                          </div>
                        </div>-->
              @endforeach
              @else
              <tr>
                <td colspan="9" class="text-center">No bookings found.</td>
              </tr>
              @endif
            </tbody>
          </table>

          <!-- Total Sum and Pay All Button -->
          @php
          $totalAmount = $bookedCars && count($bookedCars) ? $bookedCars->sum('amount_to_pay') : 0;
          @endphp
          <div class="row justify-content-end" style="margin-bottom: 20px; margin-left: 84%;">
            <div class="card shadow-sm border-primary mb-3" style="max-width: 20rem;">
              <div class="card-body p-3">
                <h6 class="card-title text-primary text-left mb-2" style="font-size: 1rem;">
                  Total Amount to Pay:
                </h6>
                <h5 class="card-text text-left mb-3" style="font-size: 1.2rem;">
                  <strong>Ksh.{{ number_format($totalAmount) }}</strong>
                </h5>
                <form method="POST" action="{{ route('makePaymentAll') }}">
                  @csrf
                  <input type="hidden" name="total_amount" value="{{ $totalAmount }}">
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#payAllModal">
                    Pay All</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Total Sum and Pay All Button -->

  <!-- Pay All Modal -->
  <div class="modal fade" id="payAllModal" tabindex="-1" role="dialog" aria-labelledby="payAllModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form method="POST" action="{{ route('makePaymentAll') }}">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="payAllModalLabel">Pay All Bookings</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            </button>
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
                <!-- <option value="card">Card</option>
              <option value="cash">Cash</option> -->
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


  @endsection