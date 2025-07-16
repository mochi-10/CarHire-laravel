@extends('layouts.backend')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-6">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title text-primary" style="font-weight:bold;">My Profile</h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered">
            <tr>
              <th>First Name</th>
              <td>{{ $user->firstname ?? 'NA' }}</td>
            </tr>
            <tr>
              <th>Last Name</th>
              <td>{{ $user->lastname ?? 'NA' }}</td>
            </tr>
            <tr>
              <th>Email</th>
              <td>{{ $user->email ?? 'NA' }}</td>
            </tr>
            <tr>
              <th>Address</th>
              <td>{{ $user->address ?? 'NA' }}</td>
            </tr>
            <tr>
              <th>Phone Number</th>
              <td>{{ $user->phonenumber ?? 'NA' }}</td>
            </tr>
          </table>
        </div>
      </div>


      <div class="box mt-4">
        <div class="box-header">
          <h3 class="box-title text-primary" style="font-weight:bold;">Update Password</h3>
        </div>
         @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif
        <div class="box-body">
          <form method="POST" action="{{ route('profile.update') }}">
            @csrf

            <div class="form-group mb-3">
              <label for="firstname">First Name</label>
              <input id="firstname" type="text"
                     class="form-control @error('firstname') is-invalid @enderror"
                     name="firstname" value="{{ old('firstname', $user->firstname) }}" required>
              @error('firstname')
                <span class="invalid-feedback d-block" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group mb-3">
              <label for="lastname">Last Name</label>
              <input id="lastname" type="text"
                     class="form-control @error('lastname') is-invalid @enderror"
                     name="lastname" value="{{ old('lastname', $user->lastname) }}" required>
              @error('lastname')
                <span class="invalid-feedback d-block" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
             <div class="form-group mb-3">
              <label for="email">Email</label>
              <input id="email" type="email"
                     class="form-control @error('email') is-invalid @enderror"
                     name="email" required>
              @error('email')
                <span class="invalid-feedback d-block" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
             <div class="form-group mb-3">
              <label for="address">Address</label>
              <input id="address" type="text"
                     class="form-control @error('address') is-invalid @enderror"
                     name="address" value="{{ old('address', $user->address) }}" required>
              @error('address')
                <span class="invalid-feedback d-block" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            
            <div class="form-group mb-3">
              <label for="current_password">Current Password</label>
              <input id="current_password" type="password"
                     class="form-control @error('current_password') is-invalid @enderror"
                     name="current_password" required>
              @error('current_password')
                <span class="invalid-feedback d-block" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group mb-3">
              <label for="password">New Password</label>
              <input id="password" type="password"
                     class="form-control @error('password') is-invalid @enderror"
                     name="password" autocomplete="new-password" required>
              @error('password')
                <span class="invalid-feedback d-block" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group mb-3">
              <label for="password_confirmation">Confirm New Password</label>
              <input id="password_confirmation" type="password"
                     class="form-control"
                     name="password_confirmation" autocomplete="new-password" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection