@extends('layouts.backend')

@section('content')

<section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title text-primary" style="font-weight:bold;">{{ $total_admins ?? 0}} : Admins List</h3>
              <button class="btn btn-primary btn-sm" style="float: right;" data-toggle="modal" data-target="#uploadFileModal">
                <i class="fa fa-upload"></i> Upload
              </button>
              <button class="btn btn-success btn-sm" style="float: right;" data-toggle="modal" data-target="#addAdminModal">
                <i class="fa fa-user-plus"></i> Add New Admin
              </button>

              <!-- <button class="btn btn-info btn-sm" style="float: right; margin-right: 5px;" data-toggle="modal" data-target="#addMemberModal">
                <i class="fa fa-user"></i> Add Member
              </button> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Fullname</th>
                  <th>Phonenumber</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th>Role</th>
                  <!-- <th>Is Member</th>  -->
                  <th>Action</th>
                </tr>
                </thead>
              <tbody>
                @foreach($admins as $key=>$admin)
                <tr>                 
                  <td>{{($admins->currentPage() - 1) * $admins->perPage() + $key + 1 }}</td>
                  <td>{{ $admin->user->firstname }} {{ $admin->user->lastname }}</td>
                  <td>{{ $admin->user->phonenumber }}</td>
                  <td>{{ $admin->user->email }}</td>
                  <td>{{ $admin->user->address }}</td>
                  <td>Admin</td>
                  <td>
                      <div class="btn-group">
                      <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown">
                        More Action <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <center><li><b>More Action</b></li></center>
                        <li class="divider"></li>
                        <li><a href="#" class="text-green" data-toggle="modal" data-target="#UpdateAdminModal{{ $admin->id }}">
                            <i class="fa fa-edit"></i> Update</a></li>
                        <li class="divider"></li>
                        <li><a href="#" class="text-red" data-toggle="modal" data-target="#deleteAdminModal{{ $admin->id }}">
                        <i class="fa fa-trash"></i> Delete</a></li>
                      </ul>
                  </div>
                </td>
              </tr>

            <!-- Update Admin Modal -->
            <div class="modal fade" id="UpdateAdminModal{{ $admin->id }}">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title text-primary" style="font-weight:bold;"><i class="fa fa-user-edit"></i> Updating Admin: {{ $admin->user->firstname ?? 'NA' }} {{ $admin->user->lastname ?? 'NA' }}</h5>
                  </div>
                  <form method="POST" action="{{ route('adminUpdateAdmin') }}">
                    @csrf
                  <div class="modal-body">
                    <input type="text" name="id" value="{{ $admin->id }}" hidden="true">
                    <div class="form-group">
                        <label>Firstname</label>
                        <input type="text" class="form-control" name="firstname" value="{{ $admin->user->firstname }}" required>
                    </div>
                    <div class="form-group">
                        <label>Lastname</label>
                        <input type="text" class="form-control" name="lastname" value="{{ $admin->user->lastname }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" value="{{ $admin->user->email }}" required>
                    </div>
                    <div class="form-group">
                        <label>Phonenumber</label>
                        <input type="text" class="form-control" name="phonenumber" value="{{ $admin->user->phonenumber }}" required>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address" value="{{ $admin->user->address }}" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- End Update Admin Modal -->

            <!-- Delete Admin Modal -->
            <div class="modal fade" id="deleteAdminModal{{ $admin->id }}">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5>Are you sure you want to delete this record?</h5>
                  </div>
                  <form method="POST" action="{{ route('adminDeleteAdmin') }}">
                    @csrf
                  <div class="modal-body">
                    <input type="text" name="id" value="{{ $admin->id }}" hidden="true">
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Delete</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- End Delete Admin Modal -->
               
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>

<!-- Upload File Modal -->
      <div class="modal fade" id="uploadFileModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="POST" action="{{ route('uploadFile') }}" enctype="multipart/form-data">
              @csrf
              <div class="modal-header">
                <h5 class="modal-title text-primary" style="font-weight:bold;"><i class="fa fa-upload"></i> Upload Users</h5>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label>Upload CSV File</label>
                  <input type="file" class="form-control" name="file" accept=".csv" required>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <p>Download File</p>
                  </div>
                  <div class="col-md-6">
                    <a href="{{ route('downloadFile', ['filename' => 'users.csv']) }}" class="btn btn-primary btn-xs">click here to download the file</a>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm">Upload</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- End Upload File Modal -->

      <!-- Add Admin Modal -->
      <div class="modal fade" id="addAdminModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="POST" action="{{ route('adminAddAdmin') }}">
              @csrf
              <div class="modal-header">
                <h5 class="modal-title text-primary" style="font-weight:bold;">
                  <i class="fa fa-user-plus"></i> Add New Admin
                </h5>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label>Firstname</label>
                  <input type="text" class="form-control" name="firstname" required autofocus>
                </div>
                <div class="form-group">
                  <label>Lastname</label>
                  <input type="text" class="form-control" name="lastname" required>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                  <label>Phonenumber</label>
                  <input type="text" class="form-control" name="phonenumber" required>
                </div>
                <div class="form-group">
                  <label>Address</label>
                  <input type="text" class="form-control" name="address" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- End Add Admin Modal -->
      
     
      <!-- Add Member Modal -->
      <!-- <div class="modal fade" id="addMemberModal">
          <div class="modal-dialog">
              <div class="modal-content">
                  <form method="POST" action="{{ route('adminAddUser') }}">
                      @csrf
                      <div class="modal-header">
                          <h5 class="modal-title text-primary" style="font-weight:bold;">
                              <i class="fa fa-user"></i> Add Company Member
                          </h5>
                      </div>
                      <div class="modal-body">
                          <input type="hidden" name="is_member" value="1">
                          <div class="form-group">
                              <label>Firstname</label>
                              <input type="text" class="form-control" name="firstname" required>
                          </div>
                          <div class="form-group">
                              <label>Lastname</label>
                              <input type="text" class="form-control" name="lastname" required>
                          </div>
                          <div class="form-group">
                              <label>Email</label>
                              <input type="text" class="form-control" name="email" required>
                          </div>
                          <div class="form-group">
                              <label>Phonenumber</label>
                              <input type="text" class="form-control" name="phonenumber" required>
                          </div>
                          <div class="form-group">
                              <label>Address</label>
                              <input type="text" class="form-control" name="address" required>
                          </div>
                          <div class="form-group">
                              <label>Role</label>
                              <select class="form-control" name="role" required>
                                  <option value="">Select ...</option>
                                  <option value="Admin">Admin</option>
                                  <option value="Customer">Customer</option>
                                  <option value="Data_clerk">Data Clerk</option>
                              </select>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                  </form>
              </div>
          </div>
      </div> -->
      
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>

@endsection