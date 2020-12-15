@extends('layouts.backend-master')
@section('bread')
    <h1>All Customers</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Customers</li>
    </ol>
@endsection
@section('content')
    <section>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Customers <span class="badge badge-success">{{$customers->count()}}</span></h3>
                        <div class="box-tools">
                            <form action="{{route('customer.index')}}" method="get">
                                <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                    <input type="text" name="search" value="{{request()->query('search')}}" class="form-control pull-right" placeholder="Search">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Customer Name</th>
                                <th>Customer Email</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            @foreach($customers as $customer)
                                <tr>
                                    <td>{{$customer->id}}</td>
                                    <td><img class="img-circle" src="{{uploadedAssets($customer->image)}}" width="45px" height="45px"></td>
                                    <td>{{$customer->name}}</td>
                                    <td>{{$customer->email}}</td>
                                    <td>
                                        @if($customer->status === 'unblocked')
                                            <span class="badge badge-success" style="background-color: seagreen">Active</span>
                                        @else
                                            <span class="badge badge-danger" style="background-color: #d73925; ">Blocked</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" onclick="RemoveItem('item-block-{{$customer->id}}','Do You Sure To (un) Block This Customer?')"> <i class="fa fa-ban"></i>   @if($customer->status === 'unblocked') Block @else Un Block @endif  </button>
                                    </td>
                                    <form action="{{route('customer.update',$customer->id)}}" id="item-block-{{$customer->id}}" method="POST">@csrf @method('PUT')
                                        <input type="hidden" name="id" value="{{$customer->id}}"></form>
                                </tr>
                            @endforeach
                            </tbody></table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {{ $customers->appends(request()->query())->links() }}
                        </ul>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection
