@extends('layouts.frontend')
@section('content')

      <div class="hero inner-page" style="background-image: url('frontend/images/hero_1_a.jpg');">

        <div class="container">
          <div class="row align-items-end ">
            <div class="col-lg-5">

              <div class="intro">
                <h1><strong>About Us</strong></h1>
                <div class="custom-breadcrumbs"><a href="{{ route('home') }}">Home</a> <span class="mx-2">/</span> <strong>About Us</strong></div>
              </div>

            </div>
          </div>
        </div>
      </div>

    

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 mb-5 mb-lg-0 order-lg-2">
            <img src="frontend/images/hero_2.jpg" alt="Image" class="img-fluid rounded">
          </div>
          <div class="col-lg-4 mr-auto">
            <h2>Car Company</h2>
            <p> Our company is dedicated to providing reliable and affordable car rental services to all our customers.</p>
            <p>We pride ourselves on excellent customer service and a wide selection of vehicles to suit every need.</p>
          </div>
        </div>
      </div>
    </div>

    

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 mb-5 mb-lg-0">
            <img src="frontend/images/hero_1.jpg" alt="Image" class="img-fluid rounded">
          </div>
          <div class="col-lg-4 ml-auto">
            <h2>Our History</h2>
            <p>Since our founding, we have grown to become a trusted name in car rentals, serving thousands of happy customers.</p>
            <p>Our commitment to quality and reliability has made us a preferred choice for both locals and visitors.</p>
          </div>
        </div>
      </div>
    </div>


    <div class="site-section bg-primary py-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-7 mb-4 mb-md-0">
            <h2 class="mb-0 text-white">What are you waiting for?</h2>
            <p class="mb-0 opa-7">Click "Rent a car now" to rent your dream car.</p>
          </div>
          <div class="col-lg-5 text-md-right">
            <a href="#" class="btn btn-primary btn-white">Rent a car now</a>
          </div>
        </div>
      </div>
    </div>
@endsection