@extends('layouts.frontend')

@section('content')
<div class="hero" style="background-image: url('frontend/images/hero_1_a.jpg');">
  <div class="container">
    <div class="row align-items-center justify-content-center">
      <div class="col-lg-10">
        <div class="row mb-5">
          <div class="col-lg-7 intro">
            <h1><strong>Hire a car</strong> is within your finger tips.</h1>
          </div>
        </div>
        <form class="trip-form" method="POST" action="{{ route('searchCar.index') }}">
          @csrf
          <div class="row align-items-center">
            <div class="mb-3 mb-md-0 col-md-6">
              <select name="car_model_id" id="car_model_id" class="custom-select form-control" required>
                <option value="">Select Model</option>
                @if(!empty($carModels))
                  @foreach($carModels as $carModel)
                    <option value="{{ $carModel->id }}">{{ $carModel->name ?? 'NA'}}</option>
                  @endforeach
                  @endif
              </select>
            </div>
            <!-- <div class="mb-3 mb-md-0 col-md-3">
              <div class="form-control-wrap">
                <input type="text" id="cf-3" placeholder="Pick up" class="form-control datepicker px-3">
                <span class="icon icon-date_range"></span>
              </div>
            </div>
            <div class="mb-3 mb-md-0 col-md-3">
              <div class="form-control-wrap">
                <input type="text" id="cf-4" placeholder="Drop off" class="form-control datepicker px-3">
                <span class="icon icon-date_range"></span>
              </div>
            </div> -->
            <div class="mb-3 mb-md-0 col-md-6">
              <input type="submit" value="Search Now" class="btn btn-primary btn-block py-3">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="site-section bg-primary py-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-7 mb-4 mb-md-0">
        <h2 class="mb-0 text-white">What are you waiting for?</h2>
        <p class="mb-0 opa-7">Hire a car now and enjoy your trip!!</p>
      </div>
      <div class="col-lg-4 ml-auto">
        <p class="mb-0"><a href="{{ route('carListings') }}" class="btn btn-white btn-outline-white">Available Cars</a></p>
      </div>
    </div>
  </div>



<!-- <div class="site-section">
  <div class="container">
    <h2 class="section-heading"><strong>How it works?</strong></h2>
    <p class="mb-5">Easy steps to get you started</p>
    <div class="row mb-5">
      <div class="col-lg-4 mb-4 mb-lg-0">
        <div class="step">
          <span>1</span>
          <div class="step-inner">
            <span class="number text-primary">01.</span>
            <h3>Select a car</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero, laboriosam!</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4 mb-lg-0">
        <div class="step">
          <span>2</span>
          <div class="step-inner">
            <span class="number text-primary">02.</span>
            <h3>Fill up form</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero, laboriosam!</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4 mb-lg-0">
        <div class="step">
          <span>3</span>
          <div class="step-inner">
            <span class="number text-primary">03.</span>
            <h3>Payment</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero, laboriosam!</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4 mx-auto">
        <a href="#" class="d-flex align-items-center play-now mx-auto">
          <span class="icon">
            <span class="icon-play"></span>
          </span>
          <span class="caption">Video how it works</span>
        </a>
      </div>
    </div>
  </div>
</div> -->

<!-- <div class="site-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-7 text-center order-lg-2">
        <div class="img-wrap-1 mb-5">
          <img src="frontend/images/feature_01.png" alt="Image" class="img-fluid">
        </div>
      </div>
      <div class="col-lg-4 ml-auto order-lg-1">
        <h3 class="mb-4 section-heading"><strong>You can easily avail our promo for renting a car.</strong></h3>
        <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae, explicabo iste a labore id est quas, doloremque veritatis! Provident odit pariatur dolorem quisquam, voluptatibus voluptates optio accusamus, vel quasi quidem!</p>
        <p><a href="#" class="btn btn-primary">Meet them now</a></p>
      </div>
    </div>
  </div>
</div> -->



<!-- <div class="site-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-7">
        <h2 class="section-heading"><strong>Features</strong></h2>
        <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4 mb-5">
        <div class="service-1 dark">
          <span class="service-1-icon">
            <span class="icon-home"></span>
          </span>
          <div class="service-1-contents">
            <h3>Lorem ipsum dolor</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati, laboriosam.</p>
            <p class="mb-0"><a href="#">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-5">
        <div class="service-1 dark">
          <span class="service-1-icon">
            <span class="icon-gear"></span>
          </span>
          <div class="service-1-contents">
            <h3>Lorem ipsum dolor</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati, laboriosam.</p>
            <p class="mb-0"><a href="#">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-5">
        <div class="service-1 dark">
          <span class="service-1-icon">
            <span class="icon-watch_later"></span>
          </span>
          <div class="service-1-contents">
            <h3>Lorem ipsum dolor</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati, laboriosam.</p>
            <p class="mb-0"><a href="#">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-5">
        <div class="service-1 dark">
          <span class="service-1-icon">
            <span class="icon-verified_user"></span>
          </span>
          <div class="service-1-contents">
            <h3>Lorem ipsum dolor</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati, laboriosam.</p>
            <p class="mb-0"><a href="#">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-5">
        <div class="service-1 dark">
          <span class="service-1-icon">
            <span class="icon-video_library"></span>
          </span>
          <div class="service-1-contents">
            <h3>Lorem ipsum dolor</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati, laboriosam.</p>
            <p class="mb-0"><a href="#">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-5">
        <div class="service-1 dark">
          <span class="service-1-icon">
            <span class="icon-vpn_key"></span>
          </span>
          <div class="service-1-contents">
            <h3>Lorem ipsum dolor</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati, laboriosam.</p>
            <p class="mb-0"><a href="#">Learn more</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="site-section bg-light">
  <div class="container">
    <div class="row">
      <div class="col-lg-7">
        <h2 class="section-heading"><strong>Testimonials</strong></h2>
        <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4 mb-4 mb-lg-0">
        <div class="testimonial-2">
          <blockquote class="mb-4">
            <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem, deserunt eveniet veniam. Ipsam, nam, voluptatum"</p>
          </blockquote>
          <div class="d-flex v-card align-items-center">
            <img src="frontend/images/person_1.jpg" alt="Image" class="img-fluid mr-3">
            <div class="author-name">
              <span class="d-block">Mike Fisher</span>
              <span>Owner, Ford</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4 mb-lg-0">
        <div class="testimonial-2">
          <blockquote class="mb-4">
            <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem, deserunt eveniet veniam. Ipsam, nam, voluptatum"</p>
          </blockquote>
          <div class="d-flex v-card align-items-center">
            <img src="frontend/images/person_2.jpg" alt="Image" class="img-fluid mr-3">
            <div class="author-name">
              <span class="d-block">Jean Stanley</span>
              <span>Traveler</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4 mb-lg-0">
        <div class="testimonial-2">
          <blockquote class="mb-4">
            <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem, deserunt eveniet veniam. Ipsam, nam, voluptatum"</p>
          </blockquote>
          <div class="d-flex v-card align-items-center">
            <img src="frontend/images/person_3.jpg" alt="Image" class="img-fluid mr-3">
            <div class="author-name">
              <span class="d-block">Katie Rose</span>
              <span >Customer</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->

<div class="site-section bg-light">
  <div class="container">
    <div class="row">
      <div class="col-lg-7">
        <h2 class="section-heading"><strong>Our Gallery</strong></h2>
        <p class="mb-5">Explore our complete collection of vehicles.</p>
      </div>
    </div>
    <div class="row">
      @foreach($allCars as $car)
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
              @php
                $isBooked = \App\Models\Booking::where('car_id', $car->id)->where('booking_status', 'active')->exists();
              @endphp
              @if($isBooked)
                <span class="badge badge-warning">Currently Booked</span>
              @else
                <span class="badge badge-success">Not Booked</span>
              @endif
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>

@endsection