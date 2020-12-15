@extends('layouts.backend-master')
@section('bread')
    <h1>All Plan Requests</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Plan Requests</li>
    </ol>
@endsection
@section('content')
    <section>
        <div class="row">
            <div class="col-md-12">
                <!-- Custom Tabs (Pulled to the right) -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li class="{{(request()->tab == 'pending' or is_null(request()->tab))?'active':''}} pull-left"><a href="#tab_1-1" data-toggle="tab" aria-expanded="true">Pending Orders</a></li>
                        <li class="pull-left {{request()->tab == 'approved'?'active':''}}"><a href="#tab_2-2" data-toggle="tab" aria-expanded="false">Approved</a></li>
                        <li class="pull-right header">All Plans Orders</li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane {{(request()->tab == 'pending' or is_null(request()->tab))?'active':''}}" id="tab_1-1">
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <tbody><tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Customer Name</th>
                                        <th>Customer Email</th>
                                        <th>Current Plan</th>
                                        <th>Payment Method</th>
                                        <th>Payment Paid</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                    @forelse($pending as $customer)
                                        <tr>
                                            <td>{{$customer->id}}</td>
                                            <td><img class="img-circle" src="{{uploadedAssets($customer->user->image)}}" width="45px" height="45px"></td>
                                            <td>{{$customer->user->name}}</td>
                                            <td>{{$customer->user->email}}</td>
                                            <td>
                                                @if(is_null($customer->user->plan_id))
                                                    <span class="badge badge-success" style="background-color: seagreen">No Plan Selected</span>
                                                @else
                                                    <span class="badge badge-danger" style="background-color: #d73925; ">{{$customer->plan->name}}</span>
                                                @endif
                                            </td>
                                            <td>{{$customer->transaction->method}}</td>
                                            <td>
                                                @if($customer->transaction->method == COD)
                                                    <span class="badge badge-danger" style="background-color: seagreen">Not Paid</span>
                                                @else
                                                    <span class="badge badge-success" style="background-color: #d73925; ">Paid</span>
                                                @endif
                                            </td>
                                            <td>{{$customer->created_at->format('Y-m-d h:i')}}</td>
                                            <td>
                                                <button  class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-default-{{$customer->id}}"> <i class="fa fa-eye"></i> More Details (Review) </button>
                                                <a href="javascript:void(0)" class="btn btn-sm btn-success" onclick="RemoveItem('item-approve-{{$customer->id}}','Do You Sure To Approve This Order?')"> <i class="fa fa-check"></i> Approve </a>
                                                <button  class="btn btn-sm btn-danger"  onclick="RemoveItem('item-remove-{{$customer->id}}','Do You Sure To Remove This Order?')"> <i class="fa fa-trash"></i> Remove </button>
                                            </td>

                                            <div class="modal fade" id="modal-default-{{$customer->id}}" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span></button>
                                                            <h4 class="modal-title">Transaction Details</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-4">
                                                                    <ul class="list-group list-group-flush">
                                                                        <li class="list-group-item text-bold">First Name</li>
                                                                        <li class="list-group-item text-bold">Last Name</li>
                                                                        <li class="list-group-item text-bold">Email</li>
                                                                        <li class="list-group-item text-bold">Phone</li>
                                                                        <li class="list-group-item text-bold">Company</li>
                                                                        <li class="list-group-item text-bold">Country</li>
                                                                        <li class="list-group-item text-bold">City</li>
                                                                        <li class="list-group-item text-bold">Address</li>
                                                                        <li class="list-group-item text-bold">PostCode</li>
                                                                        <li class="list-group-item text-bold">Method</li>
                                                                        <li class="list-group-item text-bold">Paid</li>
                                                                        <li class="list-group-item text-bold">Price</li>
                                                                        <li class="list-group-item text-bold">Plan</li>
                                                                        <li class="list-group-item text-bold">Transaction Id</li>
                                                                        <li class="list-group-item text-bold">Created At</li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-sm-12 col-md-8">
                                                                    <ul class="list-group list-group-flush">
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->first_name}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->last_name}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->email}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->phone}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->company}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->country}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->city}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->address}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->postcode}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->method}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->method==COD?'NO':'YES'}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->plan->price}} $</li>
                                                                        <li class="list-group-item text-bold">{{$customer->plan->name.' - '. $customer->plan->period}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->gateway_transaction_checkout_id?? 'NULL'}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->created_at->format('Y-m-d h:i')}}</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- /.modal -->
                                            <form action="{{route('planOrders.destroy',$customer->id)}}" id="item-remove-{{$customer->id}}" method="POST">@csrf @method('delete')</form>
                                            <form action="{{route('planOrders.approve',$customer->id)}}" id="item-approve-{{$customer->id}}" method="POST">@csrf
                                                <input type="hidden" name="id" value="{{$customer->id}}">
                                            </form>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-bold"> No Orders Available Yet ..</td>
                                        </tr>
                                    @endforelse


                                    </tbody></table>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer clearfix">
                                <ul class="pagination pagination-sm no-margin pull-right">
                                    {!! $pending->appends(['tab'=>'pending'])->links() !!}
                                </ul>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane {{request()->tab == 'approved'?'active':''}}" id="tab_2-2">
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <tbody><tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Customer Name</th>
                                        <th>Customer Email</th>
                                        <th>Current Plan</th>
                                        <th>Payment Method</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                    @forelse($approved as $customer)
                                        <tr>
                                            <td>{{$customer->id}}</td>
                                            <td><img class="img-circle" src="{{uploadedAssets($customer->user->image)}}" width="45px" height="45px"></td>
                                            <td>{{$customer->user->name}}</td>
                                            <td>{{$customer->user->email}}</td>
                                            <td><span class="badge badge-danger" style="background-color: #d73925; ">{{$customer->plan->name}}</span></td>
                                            <td>{{$customer->transaction->method}}</td>
                                            <td>{{$customer->created_at->format('Y-m-d h:i')}}</td>
                                            <td>
                                                <button  class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-approved-default-{{$customer->id}}"> <i class="fa fa-eye"></i> More Details (Review) </button>
{{--                                                <button  class="btn btn-sm btn-danger"  onclick="RemoveItem('item-remove-{{$customer->id}}','Do You Sure To Remove This Order?')"> <i class="fa fa-trash"></i> Remove </button>--}}
                                            </td>
{{--                                            <form action="{{route('planOrders.destroy',$customer->id)}}" id="item-remove-{{$customer->id}}" method="POST">@csrf @method('delete')</form>--}}
                                            <div class="modal fade" id="modal-approved-default-{{$customer->id}}" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span></button>
                                                            <h4 class="modal-title">Transaction Details</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-4">
                                                                    <ul class="list-group list-group-flush">
                                                                        <li class="list-group-item text-bold">First Name</li>
                                                                        <li class="list-group-item text-bold">Last Name</li>
                                                                        <li class="list-group-item text-bold">Email</li>
                                                                        <li class="list-group-item text-bold">Phone</li>
                                                                        <li class="list-group-item text-bold">Company</li>
                                                                        <li class="list-group-item text-bold">Country</li>
                                                                        <li class="list-group-item text-bold">City</li>
                                                                        <li class="list-group-item text-bold">Address</li>
                                                                        <li class="list-group-item text-bold">PostCode</li>
                                                                        <li class="list-group-item text-bold">Method</li>
                                                                        <li class="list-group-item text-bold">Paid</li>
                                                                        <li class="list-group-item text-bold">Price</li>
                                                                        <li class="list-group-item text-bold">Plan</li>
                                                                        <li class="list-group-item text-bold">Transaction Id</li>
                                                                        <li class="list-group-item text-bold">Created At</li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-sm-12 col-md-8">
                                                                    <ul class="list-group list-group-flush">
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->first_name}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->last_name}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->email}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->phone}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->company}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->country}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->city}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->address}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->postcode}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->method}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->method==COD?'NO':'YES'}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->plan->price}} $</li>
                                                                        <li class="list-group-item text-bold">{{$customer->plan->name.' - '. $customer->plan->period}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->gateway_transaction_checkout_id?? 'NULL'}}</li>
                                                                        <li class="list-group-item text-bold">{{$customer->transaction->created_at->format('Y-m-d h:i')}}</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-bold"> No Orders Available Yet ..</td>
                                        </tr>
                                    @endforelse
                                    </tbody></table>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer clearfix">
                                <ul class="pagination pagination-sm no-margin pull-right">
                                    {!! $approved->appends(['tab'=>'approved'])->links() !!}
                                </ul>
                            </div>
                        </div>
                        <!-- /.tab-pane -->


                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->
            </div>




















        </div>
    </section>
@endsection
