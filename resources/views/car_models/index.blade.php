@extends('layouts.backend')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title text-primary" style="font-weight:bold;">{{ $total_models ?? 0}} : Car Models List</h3>
                    <button class="btn btn-success btn-sm" style="float: right;" data-toggle="modal" data-target="#addCarModelModal">
                        <i class="fa fa-plus"></i> Add Car Model
                    </button>
                </div>
                <div class="box-body">
                    <div class="row mb-3">
                        <div class="col-md-4 col-sm-6">
                            <input type="text" id="carModelSearch" class="form-control" placeholder="Search Car Model...">
                        </div>
                    </div>
                    <table id="carModelsTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Model Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carModels as $key => $model)                           
                            <tr>
                                <td>{{ ($carModels->currentPage() - 1) * $carModels->perPage() + $key + 1 }}</td>
                                <td>{{ $model->name }}</td>
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
                                                <a href="#" class="text-blue" data-toggle="modal" data-target="#viewCarModelModal{{ $model->id }}">
                                                    <i class="fa fa-eye"></i> View Cars
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a href="#" class="text-green" data-toggle="modal" data-target="#editCarModelModal{{ $model->id }}">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a href="#" class="text-red" data-toggle="modal" data-target="#deleteCarModelModal{{ $model->id }}">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <!-- View Cars Modal -->
                            <div class="modal fade" id="viewCarModelModal{{ $model->id }}" tabindex="-1" role="dialog" aria-labelledby="viewCarModelModalLabel{{ $model->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-primary" style="font-weight:bold;">Cars for {{ $model->name }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @if($model->cars && $model->cars->count())
                                                <ul class="list-group">
                                                    @foreach($model->cars as $car)
                                                        <li class="list-group-item">
                                                            <strong>{{ $loop->iteration }}.</strong><br>
                                                            <strong>Make:</strong> {{ $car->make }}<br>
                                                            <strong>Registration:</strong> {{ $car->registration_number }}<br>
                                                            <strong>Year:</strong> {{ $car->year }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p>No cars found for this model.</p>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editCarModelModal{{ $model->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <form method="POST" action="{{ route('car-models.update', $model->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-primary" style="font-weight:bold;">Edit Car Model</h5>
                                                
                                            </div>
                                            <div class="modal-body">
                                                <input type="text" name="name" class="form-control" value="{{ $model->name }}" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteCarModelModal{{ $model->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <form method="POST" action="{{ route('car-models.destroy', $model->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-primary" style="font-weight:bold;">Delete Car Model</h5>
                                               
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete <b>{{ $model->name }}</b>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center" style="float:left;">
                                {{ $carModels->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Car Model Modal -->
    <div class="modal fade" id="addCarModelModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('car-models.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary" style="font-weight:bold;">Add Car Model</h5>
                        
                    </div>
                    <div class="modal-body">
                        <input type="text" name="name" class="form-control" placeholder="Car Model Name" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Add</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
document.getElementById('carModelSearch').addEventListener('keyup', function() {
    var filter = this.value.toLowerCase();
    var rows = document.querySelectorAll('#carModelsTable tbody tr');
    rows.forEach(function(row) {
        var modelName = row.children[1].textContent.toLowerCase();
        row.style.display = modelName.includes(filter) ? '' : 'none';
    });
});
</script>
@endsection