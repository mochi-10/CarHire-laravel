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
                
                <!--Rate per km-->
                <li>Rate per Km:
                  <form method="POST" action="{{ route('bookCarPerKm', ['car_id' => $car->id]) }}">
                    @csrf
                    <input type="hidden" name="car_id" value="{{ $car->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="rate_per_km" value="{{ $car->rate_per_km }}">
                    <div class="form-group row">
                      <div class="col-md-6 mb-4 mb-lg-0">
                        <label>Enter Number Kilometers</label>
                      </div>
                      <div class="col-md-6">
                        <input type="number" name="total_km" class="form-control" min="25" placeholder="Number of KM" required>
                      </div>
                    </div>               
                    <p class="mt-4">
                      <button type="submit" class="btn btn-primary w-75">submit</button>
                    </p>
                  </form>             
                </li>
              </ul>
                <!--end Rate per Km-->

            @else
              <p>Car details not found.</p>
            @endif
          </div>
        </div>
      </div>
    </div>
    </div>
@endsection