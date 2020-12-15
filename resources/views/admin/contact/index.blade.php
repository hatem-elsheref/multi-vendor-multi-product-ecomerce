@extends('layouts.backend-master')
@section('bread')
    <h1>All Contacts</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Contacts</li>
    </ol>
@endsection
@section('content')
    <section>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Contacts <span class="badge badge-success">{{$contacts->count()}}</span></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Website</th>
                                <th>Status</th>
                                <th>Message</th>
                                <th>Actions</th>
                            </tr>
                            @foreach($contacts as $contact)
                                <tr>
                                    <td>{{$contact->id}}</td>
                                    <td>{{$contact->firstname.' '.$contact->last_name}}</td>
                                    <td>{{$contact->email}}</td>
                                    <td>
                                        <a class="btn btn-sm btn-info" href="{{$contact->website}}" target="_blank"> <i class="fa fa-globe"></i> Website</a>
                                    </td>
                                    <td>
                                        @if($contact->status === 'read')
                                            <span class="badge badge-success" style="background-color: seagreen">Read</span>
                                        @else
                                            <span class="badge badge-danger" style="background-color: #d73925; ">Un Read</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-view-{{$contact->id}}"> <i class="fa fa-eye"></i> View</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-reply-{{$contact->id}}"> <i class="fa fa-reply"></i> Reply  </button>
                                        <a class="btn btn-sm btn-success" href="{{route('contact.update',$contact->id)}}"> <i class="fa fa-check"></i> Change The Status  </a>
                                        <button class="btn btn-sm btn-danger" onclick="RemoveItem('item-remove-{{$contact->id}}','Do You Sure To Remove This Message?')"> <i class="fa fa-trash"></i>   Remove </button>
                                    </td>
                                    <form action="{{route('contact.destroy',$contact->id)}}" id="item-remove-{{$contact->id}}" method="POST">@csrf @method('DELETE') </form>
                                    <div class="modal fade" id="modal-reply-{{$contact->id}}" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span></button>
                                                    <h4 class="modal-title">Reply To User</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{route('contact.reply')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="email" value="{{$contact->email}}">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <input class="form-control" name="subject" placeholder="Subject:">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <textarea name="message" class="form-control" placeholder="message" rows="10">{{old('message')}}</textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="submit" value="Send" class="btn btn-primary">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <div class="modal fade" id="modal-view-{{$contact->id}}" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span></button>
                                                    <h4 class="modal-title">View User Message</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <input class="form-control" value="{{$contact->subject}}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <textarea  class="form-control"  rows="10" readonly>{{$contact->message}}</textarea>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </tr>
                            @endforeach
                            </tbody></table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {!!  $contacts->links() !!}
                        </ul>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>


    </section>
@endsection
