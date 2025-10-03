@extends('layouts.backend')
@section('content')

<section class="content-header">
    <h1 class="text-primary" style="font-weight:bold;">{{ $total_messages ?? 0 }} : Customer Messages</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('contact.messages') }}">Customer Messages</a></li>
    </ol>
</section>

<div class="box-body table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Fullname</th>
                <!-- <th>Phonenumber</th> -->
                <th>Email</th>
                <th>Message</th>
                <th>Date Sent</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($messages as $key => $msg)
                <tr>
                    <td>{{($messages->currentPage() - 1) * $messages->perPage() + $key + 1 }}</td>
                    <td>
                        @if($msg->user)
                            {{ $msg->user->firstname }} {{ $msg->user->lastname }}
                        @else
                            Guest
                        @endif
                    </td>
                    <!-- <td>
                        @if($msg->user)
                            {{ $msg->user->phonenumber }}
                        @else
                            -
                        @endif
                    </td> -->
                    <td>
                        @if($msg->user)
                            {{ $msg->user->email }}
                        @else
                            {{ $msg->email ?? '-' }}
                        @endif
                    </td>
                    <td>{{ $msg->message }}</td>
                    <td>{{ $msg->created_at->format('d M Y, H:i') }}</td>
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
                                    <a href="#" class="text-primary" style=color:blue; data-toggle="modal" data-target="#replyMessageModal{{ $msg->id }}">
                                        <i class="fa fa-reply"></i> Reply
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>                  
                                    <a href="#" class="text-danger" style=color:red; data-toggle="modal" data-target="#deleteMessageModal{{ $msg->id }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Reply Modal -->
                        <div class="modal fade" id="replyMessageModal{{ $msg->id }}" tabindex="-1" role="dialog" aria-labelledby="replyMessageModalLabel{{ $msg->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="{{ route('replyMessage', $msg->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-primary" id="replyMessageModalLabel{{ $msg->id }}">
                                                Reply to
                                                @if($msg->user)
                                                    {{ $msg->user->firstname }} {{ $msg->user->lastname }}
                                                @else
                                                    Guest
                                                @endif
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                               
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="reply" class="text-primary">Reply Message</label>
                                                <textarea class="form-control" name="reply" id="reply" rows="5" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Send Reply</button>
                                        </div>
                                    </div>
                                </form>
                            </div>                         
                        </div>


                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteMessageModal{{ $msg->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteMessageModalLabel{{ $msg->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="{{ route('deleteMessage', $msg->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-primary" id="deleteMessageModalLabel{{ $msg->id }}">Delete Message</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this message?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
   <!-- Pagination -->
    <div class="d-flex justify-content-end mt-3">
        <nav aria-label="Messages pagination">
            <ul class="pagination pagination-lg" style="margin:0;">
                {{ $messages->onEachSide(1)->links('pagination::bootstrap-4') }}
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
@endsection