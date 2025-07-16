@extends('layouts.frontend')
@section('content')
<div class="hero inner-page" style="background-image: url('frontend/images/hero_1_a.jpg');">
        
    <div class="container">
        <div class="row align-items-end ">
        <div class="col-lg-5">

            <div class="intro">
            <h1><strong>Register</strong></h1>
            <div class="custom-breadcrumbs"><a href="index.html">Home</a> <span class="mx-2">/</span> <strong>Register</strong></div>
            </div>

        </div>
        </div>
    </div>
</div>


<div class="site-section bg-light" id="contact-section">
      <div class="container">
        <div class="row justify-content-center text-center">
        <div class="col-7 text-center mb-5">
          <!--<h2>Contact Us Or Use This Form To Rent A Car</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo assumenda, dolorum necessitatibus eius earum voluptates sed!</p>-->
        </div>
      </div>
        <div class="row">
          <div class="col-lg-12 mb-5" >
            <form action="{{route('register')}}" method="POST">
                @csrf
              <div class="form-group row">
                <div class="col-md-6 mb-4 mb-lg-0">
                    <label>Firstname</label>
                  <input type="text" class="form-control"  name="firstname" placeholder="Enter firstname">
                </div>
                <div class="col-md-6">
                  <label>Lastname</label>
                  <input type="text" class="form-control" name="lastname" placeholder="Enter lastname">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-6">
                  <label>Email</label>
                  <input type="email" class="form-control" placeholder="Email address" name="email">
                </div>

                <div class="col-md-6">
                  <label>Phonenumber</label>
                  <input type="text" class="form-control" placeholder="Phonenumber" name="phonenumber">
                </div>

              </div>

              <div class="form-group row">
                <div class="col-md-6">
                  <label>Address</label>
                  <textarea name="address"  class="form-control" placeholder="Write your address"></textarea>
                </div>
                 <div class="col-md-6">
                  <label>Password</label>
                  <input type="password" class="form-control" placeholder="Enter Password" name="password">
                </div>
              </div>
              
                <div class="col-md-6 mr-auto" style="padding-top:35px">
                  <input type="submit" class="btn btn-primary text-white py-2 px-4" value="Submit">
                </div>
              </div>

              <input type="text" name="role" value="Customer" hidden="true">

            </form>
          </div>
          
        </div>
      </div>
    </div>
@endsection