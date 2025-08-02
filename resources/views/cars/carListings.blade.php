@extends('layouts.frontend')

@section('content')
<div class="site-section bg-light" style="margin-top: 140px;">
  <div class="container">
    <div class="row">
      <div class="col-lg-7">
        <h2 class="section-heading"><strong>Car Listings</strong></h2>
        <p class="mb-5">Browse our available cars below.</p>
      </div>
    </div>
    <div class="row">
      @foreach($cars as $car)
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="listing d-block align-items-stretch">
          <div class="listing-img h-100 mr-4">
            @if($car->image)
              <img src="{{ asset('images/' . $car->image) }}" alt="Image" class="img-fluid">
            @else
              <img src="{{ asset('images/default-car.png') }}" alt="No Image" class="img-fluid">
            @endif
          </div>
          <div class="listing-contents h-100">
            <h3>{{ $car->make }} {{ $car->carModel->name ?? $car->model }}</h3>
            <div class="rent-price">
              <strong>Ksh {{ number_format($car->rate_per_day) }}</strong><span class="mx-1">/</span>day |
              <strong>Ksh {{ number_format($car->rate_per_km) }}</strong><span class="mx-1">/</span>Km
            </div>
            <div class="d-block d-md-flex mb-3 border-bottom pb-3">
              <div class="listing-feature pr-4">
                <span class="caption">Year:</span>
                <span class="number">{{ $car->year }}</span>
              </div>
              <div class="listing-feature pr-4">
                <span class="caption">Color:</span>
                <span class="number">{{ $car->color }}</span>
              </div>
              <div class="listing-feature pr-4">
                <span class="caption">Reg:</span>
                <span class="number">{{ $car->registration_number }}</span>
              </div>
            </div>
            <div>
              <p>
                <a href="{{ route('carDetailsPerDay', ['car_id' => $car->id]) }}" class="btn btn-primary btn-sm mr-2">Rent(Day)</a>
                <a href="{{ route('carDetailsPerKm', ['car_id' => $car->id]) }}" class="btn btn-primary btn-sm">Rent(Km)</a>
              </p>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection