@extends('layouts.frontend')

@section('content')
<div class="hero inner-page" style="background-image: url('frontend/images/hero_1_a.jpg');">
  <div class="container">
    <div class="row align-items-end ">
      <div class="col-lg-5">
        <div class="intro">
          <h1><strong>Car Details</strong></h1>
          <div class="custom-breadcrumbs"><a href="{{route('welcome')}}">Home</a> <span class="mx-2">/</span> <strong>Car Details</strong></div>
        </div>
      </div>
    </div>
    <div class="site-section">
      <div class="container">
        <div class="row">

          <div class="col-lg-6 mb-5 mb-lg-0">
            @if($car && $car->image)
            <img src="{{ asset('images/' . $car->image) }}" alt="Car Image" class="img-fluid rounded w-75" style="max-height:400px; object-fit:cover;">
            @else
            <p>No image available for this car.</p>
            @endif
          </div>

          <div class="col-lg-6">
            <h2>Car Details</h2>
            @if($car)
            <ul class="list-unstyled">

              <li><strong>Make:</strong> {{ $car->make }}</li>
              <li><strong>Model:</strong> {{ $car->carModel->name ?? '' }}</li>
              <li><strong>Year:</strong> {{ $car->year }}</li>
              <li><strong>Color:</strong> {{ $car->color }}</li>
              <li><strong>Registration Number:</strong> {{ $car->registration_number }}</li>

              <li>Rate per Km: Ksh {{ number_format($car->rate_per_km) }}
                <div id="rate-data" data-rate="{{ $car->rate_per_km }}" style="display: none;"></div>
                <form method="POST" action="{{ route('redirectToPaymentPagePerKm') }}" id="bookingForm">
                  @csrf
                  <div class="form-group row">
                    <input type="hidden" name="car_id" value="{{ $car->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="rate_per_km" value="{{ $car->rate_per_km }}">
                    <div class="col-md-6 mb-4 mb-lg-0">
                      <label>Enter Number of Kilometers</label>
                    </div>
                    <div class="col-md-6">
                      <input type="number" name="total_km" id="total_km" class="form-control" min="1" placeholder="Number of Kilometers" required>
                    </div>
                  </div>

                  <script>
                  document.addEventListener('DOMContentLoaded', function() {
                      const rate = parseFloat(document.getElementById('rate-data').dataset.rate);
                      const kmInput = document.getElementById('total_km');
                      const amountDisplay = document.getElementById('amount-display');

                      function updateAmount() {
                          const km = parseInt(kmInput.value) || 0;
                          const amount = rate * km;
                          amountDisplay.textContent = amount.toLocaleString();
                      }

                      kmInput.addEventListener('input', updateAmount);
                  });
                  </script>
                  
                  <!-- Amount Display Box -->
                  <div class="form-group row mt-3">
                    <div class="col-md-6 mb-4 mb-lg-0">
                      <label>Total Amount:</label>
                    </div>
                    <div class="col-md-6">
                      <div class="form-control bg-light" style="font-weight: bold; color: #007bff;">
                        Ksh <span id="amount-display">0</span>
                      </div>
                    </div>
                  </div>

                  <div class="mt-4">
                    <button type="submit" class="btn btn-success w-75 mb-2">Payment & Book</button>
                  </div>
                </form>
              </li>
            </ul>

            @else
            <p>Car details not found.</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection