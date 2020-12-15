@extends('layouts.backend-master')
@section('bread')
    <h1>All {{$type}}</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">{{$type }} Orders</li>
    </ol>
@endsection
@section('content')
    <section>
        <div class="row">

            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Orders <span class="badge badge-success">{{$orders->count()}}</span></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Payment Method</th>
                                <th>Shipping Details</th>
                                <th>View Order Items</th>
                                <th>Actions</th>
                            </tr>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->user->name}}</td>
                                    <td>{{$order->user->email}}</td>
                                    <td>{{$order->created_at->format('Y-m-d h:i')}}</td>
                                    <td>{{$order->total}}</td>
                                    <td>{{$order->method}}</td>
                                    <td><button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-shipping-{{$order->id}}"> <i class="fa fa-info"></i> View Shipping Details </button></td>
                                    <td><button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-view-{{$order->id}}"> <i class="fa fa-eye"></i> View Order Items Details </button></td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" onclick="RemoveItem('item-{{$order->id}}')"> <i class="fa fa-trash"></i>   Remove </button>

                                        @if($order->status == PENDING)
                                            <button class="btn btn-sm btn-success" onclick="getTheTimeToShipTheOrder('ship-item-{{$order->id}}')"> <i class="fa fa-check"></i> Approve </button>
                                        @endif
                                        @if($order->status == SHIPPED)
                                            <button class="btn btn-sm btn-success" onclick="document.getElementById('deliver-item-{{$order->id}}').submit()"> <i class="fa fa-check"></i> Delivered </button>
                                        @endif

                                    </td>
                                    <form action="{{route('orders.destroy',$order->id)}}" id="item-{{$order->id}}" method="POST"> @csrf @method('DELETE') </form>
                                    @if($order->status == PENDING)
                                    <form action="{{route('orders.approve',$order->id)}}" id="ship-item-{{$order->id}}" method="POST"> @csrf
                                        <input type="hidden" name="time_to_shipping" id="time_to_shipping">
                                    </form>
                                    @endif
                                    @if($order->status == SHIPPED)
                                        <form action="{{route('orders._delivered',$order->id)}}" id="deliver-item-{{$order->id}}" method="POST"> @csrf</form>
                                    @endif
                                    <div class="modal fade" id="modal-shipping-{{$order->id}}" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span></button>
                                                    <h4 class="modal-title">Shipping Details</h4>
                                                </div>
                                                <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Name</label>
                                                                    <input class="form-control" disabled value="{{$order->first_name .' '.$order->last_name}}" >
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label>Company</label>
                                                                <div class="form-group">
                                                                    <input class="form-control" disabled value="{{$order->company}}" >
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label>Country</label>
                                                                <div class="form-group">
                                                                    <input class="form-control" disabled value="{{$order->country}}" >
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label>City</label>
                                                                <div class="form-group">
                                                                    <input class="form-control" disabled value="{{$order->city}}" >
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label>Postcode</label>
                                                                <div class="form-group">
                                                                    <input class="form-control" disabled value="{{$order->postcode}}" >
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label>Phone</label>
                                                                <div class="form-group">
                                                                    <input class="form-control" disabled value="{{$order->phone}}" >
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label>Address</label>
                                                                <div class="form-group">
                                                                    <input class="form-control" disabled value="{{$order->address}}" >
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label>Payment</label>
                                                                <div class="form-group">
                                                                    <input class="form-control" disabled value="{{$order->method}}" >
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
                                    <div class="modal fade" id="modal-view-{{$order->id}}" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span></button>
                                                    <h4 class="modal-title">Order Items</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <ul class="list-group list-group-flush">
                                                                @foreach($order->items as $item)
                                                                <li class="list-group-item">{{$item->product->name}} <span class="text-danger">x</span> {{$item->quantity}} <span class="text-danger">=</span> {{$item->product->price*$item->quantity}}$</li>
                                                                @endforeach
                                                            </ul>
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
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {!! $orders->links() !!}
                        </ul>
                    </div>
                </div>
                <!-- /.box -->

            </div>
        </div>
    </section>
@endsection
@section('js')
    <script>
        @if($type == 'Pending')
        function getTheTimeToShipTheOrder(form){
            let days=Number.parseInt(prompt('Enter The Number Of Days To Ship The Order ?'));
            if (Number.isInteger(days)){
                $('#time_to_shipping').val(days);
                $('#'+form).submit();
            }else{
                alert('Enter A Correct Value To Days !!')
            }
        }
        @endif
    </script>
@endsection
