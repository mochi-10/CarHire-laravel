@extends('layouts.backend')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 class="text-primary" style="font-weight:bold;">Dashboard</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="active">Admin</li>
      </ol>
    </section>
    

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $total_models ?? 0 }}</h3>

              <p>Models</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="{{ route('car-models.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Cars</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('cars.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ $total_users ?? 0 }}</h3>

              <p>Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('users.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ $total_booked_cars ?? 0 }}</h3>

              <p>Rented Cars</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

  <div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title text-primary" style="font-weight:bold;">{{ $total_cars ?? 0}} : Recently Registered Cars</h3>
            </div>
            <div class="box-body">
                <div class="row mb-3">
                    <!-- <div class="col-md-4 col-sm-6">
                        <input type="text" id="carTableSearch" class="form-control" placeholder="Search Car...">
                    </div> -->
                </div>
                <table id="carsTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Car Image</th>
                            <th>Make</th>
                            <th>Model</th>
                            <th>Registration</th>
                            <th>Year</th>
                            <th>Color</th>
                            <!-- <th>Rate/Day</th>
                            <th>Rate/Km</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cars as $key => $car)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                @if($car->image)
                                    <img src="{{ asset('images/' . $car->image) }}" class="img-responsive" style="width:100px; height:60px; object-fit:cover;" alt="Car Image">
                                @else
                                    <img src="{{ asset('images/default-car.png') }}" class="img-responsive" style="width:100px; height:60px; object-fit:cover;" alt="No Image">
                                @endif
                            </td>
                            <td>{{ $car->make }}</td>
                            <td>{{ $car->carModel->name ?? 'NA' }}</td>
                            <td>{{ $car->registration_number }}</td>
                            <td>{{ $car->year }}</td>
                            <td>{{ $car->color }}</td>
                            <!-- <td>{{ $car->rate_per_day }}</td>
                            <td>{{ $car->rate_per_km }}</td> -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->

    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title text-primary" style="font-weight:bold;">{{ $bookedCars->count() ?? 0 }} : Booked Cars</h3>
            </div>
            <div class="box-body">
                <table id="bookedCarsTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Car Image</th>
                            
                            <th>Model</th>
                            <th>Registration</th>
                            <th>Total Days</th>
                            <th>Total KM</th>
                            <th>Amount to pay</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookedCars as $key => $booking)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                @if($booking->car && $booking->car->image)
                                    <img src="{{ asset('images/' . $booking->car->image) }}" class="img-responsive" style="width:100px; height:60px; object-fit:cover;" alt="Car Image">
                                @else
                                    <img src="{{ asset('images/default-car.png') }}" class="img-responsive" style="width:100px; height:60px; object-fit:cover;" alt="No Image">
                                @endif
                            </td>
                            <td>{{ $booking->car->carModel->name ?? 'NA' }}</td>
                            <td>{{ $booking->car->registration_number ?? 'NA' }}</td>
                            <td>{{ $booking->total_days ?? 'NA' }}</td>
                            <td>{{ $booking->total_km ?? 'NA' }}</td>
                            <td>{{ $booking->amount_to_pay ?? 'NA' }}</td>
                            <!-- Example: show booking-specific data -->
                            <!-- <td>{{ $booking->created_at->format('Y-m-d') }}</td> -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.col -->
</div>
    </section>
    <!-- /.content -->
    <!-- Content Header (Page header) -->
   
    <!-- /.content -->
@endsection
