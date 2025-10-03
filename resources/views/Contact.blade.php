@extends('layouts.frontend')
@section('content')

<div class="hero inner-page" style="background-image: url('frontend/images/hero_1_a.jpg');">

  <div class="container">
    <div class="row align-items-end ">
      <div class="col-lg-5">

        <div class="intro">
          <h1><strong>Contact Us</strong></h1>
          <div class="custom-breadcrumbs"><a href="index.html">Home</a> <span class="mx-2">/</span> <strong>Contact Us</strong></div>
        </div>

      </div>
    </div>
  </div>
</div>

<div class="site-section bg-light" id="contact-section">
  <div class="container">
    <div class="row justify-content-center text-center">
      <!-- <div class="col-7 text-center mb-5" style="margin-top: 0px;">
          <h2>Contact Us</h2>
          
        </div> -->
    </div>
    <div class="row">
      <div class="col-lg-8 mb-5">
        <form action="{{ route('contact.submit') }}" method="post">
          @csrf
          @if(Auth::check())
          <input type="hidden" name="user_id" value="{{ Auth::id() }}">
          @endif

          <label>Write your message</label>
          <div class="form-group row">
            <div class="col-md-12">
              <textarea name="message" class="form-control" placeholder="..." cols="30" rows="10" required></textarea>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-6 mr-auto">
              <input type="submit" class="btn btn-block btn-primary text-white py-3 px-5" value="Send Message">
            </div>
          </div>
        </form>
      </div>
      <div class="col-lg-4 ml-auto">
        <div class="bg-white p-3 p-md-5">
          <h3 class="text-black mb-4">Contact Info</h3>
          <ul class="list-unstyled footer-link">
            <li class="d-block mb-3">
              <span class="d-block text-black">Address:</span>
              <span>Nairobi, Kenya</span>
            </li>
            <li class="d-block mb-3"><span class="d-block text-black">Phone:</span><span>+254 712 613928</span></li>
            <li class="d-block mb-3"><span class="d-block text-black">Email:</span><span>mochibrian10@gmail.com</span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection