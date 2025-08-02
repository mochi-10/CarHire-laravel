@extends('layouts.backend')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title text-primary" style="font-weight:bold;">{{ $total_cars ?? 0}} : Cars List</h3>
                    <button class="btn btn-success btn-sm" style="float: right;" data-toggle="modal" data-target="#addCarModal">
                        <i class="fa fa-plus"></i> Add New Car
                    </button>
                </div>
                <div class="box-body table-responsive">
                    <div class="row mb-3">
                    <div class="col-md-4 col-sm-6">
                        <input type="text" id="carTableSearch" class="form-control" placeholder="Search Car...">
                    </div>
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
                                <th>Rate/Day</th>
                                <th>Rate/Km</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cars as $key => $car)
                            <tr>
                                <td>{{ ($cars->currentPage() - 1) * $cars->perPage() + $key + 1 }}</td>
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
                                <td>{{ $car->rate_per_day }}</td>
                                <td>{{ $car->rate_per_km }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown">
                                            More Action <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <center><li><b>More Action</b></li></center>
                                            <li class="divider"></li>
                                            <li>
                                                <a href="#" class="text-green" data-toggle="modal" data-target="#UpdateCarModal{{ $car->id }}">
                                                    <i class="fa fa-edit"></i> Update
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a href="#" class="text-red" data-toggle="modal" data-target="#DeleteCarModal{{ $car->id }}">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <div class="d-flex justify-content-end mt-3">
                        <nav aria-label="Car pagination">
                            <ul class="pagination pagination-lg" style="margin:0;">
                                {{ $cars->onEachSide(1)->links('pagination::bootstrap-4') }}
                            </ul>
                        </nav>
                    </div>

                    <style>
                        .pagination-lg .page-link {
                            font-size: 1.2rem;
                            padding: 0.75rem 1.25rem;
                            color: #007bff;
                            border-radius: 0.3rem;
                            margin: 0 2px;
                            transition: background 0.2s, color 0.2s;
                        }
                        .pagination-lg .page-item.active .page-link {
                            background-color: #007bff;
                            color: #fff;
                            border-color: #007bff;
                        }
                        .pagination-lg .page-link:hover {
                            background: #e9ecef;
                            color: #0056b3;
                        }
                    </style>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>


    <!-- Cars Section -->
    <!-- <h3 class="text-primary" style="font-weight:bold; margin-top:40px;">{{ $total_cars ?? 0}} : Cars</h3>
    <div class="row">
        @foreach($cars as $car)
            <div class="col-md-3">
                <div class="card" style="margin-bottom:20px;">
                    @if($car->image)
                        <img src="{{ asset('images/' . $car->image) }}" class="card-img-top img-responsive" style="width:100%; height:180px; object-fit:cover;" alt="Car Image">
                    @else
                        <img src="{{ asset('images/default-car.png') }}" class="card-img-top img-responsive" style="width:100%; height:180px; object-fit:cover;" alt="No Image">
                    @endif
                    <div class="card-body">
                        <h4 class="card-title">{{ $car->make }} {{ $car->model }}</h4>
                        <p class="card-text">
                            <b>Reg:</b> {{ $car->registration_number }}<br>
                            <b>Year:</b> {{ $car->year }}<br>
                            <b>Color:</b> {{ $car->color }}<br>
                             <b>
                        @if(isset($car->rate_per_day))
                            Rate/Day: {{ $car->rate_per_day }}<br>
                            Rate/Km: {{ $car->rate_per_km }}
                        @else
                            Rate/Day: {{ $car->rate_per_day }}<br>
                            Rate/Km: {{ $car->rate_per_km }}
                        @endif
                        </b>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div> -->
    <!-- End Cars Section -->


    <!-- Update Car Modals -->
    @foreach($cars as $car)
    <div class="modal fade" id="UpdateCarModal{{ $car->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('adminUpdateCar') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $car->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary" style="font-weight:bold;">
                            <i class="fa fa-pencil"></i> Update Car
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Car Image</label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label>Make</label>
                            <input type="text" class="form-control" name="make" value="{{ $car->make }}" required>
                        </div>
                        <!-- <div class="form-group">
                            <label>Model</label>
                            <input type="text" class="form-control" name="model" value="{{ $car->model }}" required>
                        </div> -->
                        <div class="form-group">
                            <label>Registration Number</label>
                            <input type="text" class="form-control" name="registration_number" value="{{ $car->registration_number }}" required>
                        </div>
                        <div class="form-group">
                            <label>Year</label>
                            <select class="form-control" name="year" required>
                                @for($y = 1999; $y <= date('Y'); $y++)
                                    <option value="{{ $y }}" {{ $car->year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Color</label>
                            <input type="text" class="form-control" name="color" value="{{ $car->color }}" required>
                        </div>
                        <div class="form-group">
                            <label>Rate Per Day</label>
                            <input type="number" step="1000" class="form-control" name="rate_per_day" value="{{ $car->rate_per_day }}" required>
                        </div>
                        <div class="form-group">
                            <label>Rate Per Km</label>
                            <input type="number" step="100" class="form-control" name="rate_per_km" value="{{ $car->rate_per_km }}" required>
                        </div>
                       
                    </div>
            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    <!-- End Update Car Modals -->

    <!-- Delete Car Modals -->
    @foreach($cars as $car)
    <div class="modal fade" id="DeleteCarModal{{ $car->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('adminDeleteCar') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $car->id }}">
                    <div class="modal-header">
                        <h5>Are you sure you want to delete this car?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    <!-- End Delete Car Modals -->

    <!-- Add Car Modal -->
    <div class="modal fade" id="addCarModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('adminAddCar') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title text-primary" style="font-weight:bold;">
                            <i class="fa fa-plus"></i> Add New Car
                        </h5>
                    </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Car Model</label>
                                <select class="form-control" name="car_model_id" required>
                                    <option value="">select model ...</option>
                                    @foreach($car_models as $model)
                                    <option value="{{ $model->id }}">{{ $model->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        <div class="form-group">
                            <label>Car Image</label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                        </div>   
                        <div class="form-group">
                            <label>Make</label>
                            <input type="text" class="form-control" name="make" required>
                        </div>
                        <!-- <div class="form-group">
                            <label>Model</label>
                            <input type="text" class="form-control" name="model" required>
                        </div> -->
                        <div class="form-group">
                            <label>Registration Number</label>
                            <input type="text" class="form-control" name="registration_number" required>
                        </div>
                         <div class="form-group">
                            <label>Year</label>
                            <select class="form-control" name="year" required>
                                @for($y = 1999; $y <= date('Y'); $y++)
                                    <option value="{{ $y }}" {{ $car->year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Color</label>
                            <input type="text" class="form-control" name="color" required>
                        </div>
                        <div class="form-group">
                            <label>Rate Per Day</label>
                            <input type="number" step="1000" class="form-control" name="rate_per_day" required>
                        </div>
                        <div class="form-group">
                            <label>Rate Per Km</label>
                            <input type="number" step="100" class="form-control" name="rate_per_km" required>
                        </div>
                       
                  </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Add Car Modal -->
</section>

<script>
document.getElementById('carTableSearch').addEventListener('keyup', function() {
    var filter = this.value.toLowerCase();
    var rows = document.querySelectorAll('#carsTable tbody tr');
    rows.forEach(function(row) {
        var text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>

@endsection