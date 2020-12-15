@extends('layouts.backend-master')
@section('bread')
    <h1>All Sellers</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Sellers</li>
    </ol>
@endsection
@section('content')
    <section>
        <div class="row">

            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Sellers <span class="badge badge-success">{{$sellers->count()}}</span></h3>
                        <div class="box-tools">
                            <form action="{{route('seller.index')}}" method="get">
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
                                <th>Seller Name</th>
                                <th>Seller Stock Name</th>
                                <th>Seller Email</th>
                                <th>Seller Plan</th>
                                <th>Plan End At</th>
                                <th>Status</th>
                                <th>Best Seller</th>
                                <th>Actions</th>
                            </tr>
                            @foreach($sellers as $seller)
                                <tr>
                                    <td>{{$seller->id}}</td>
                                    <td><img class="img-circle" src="{{uploadedAssets($seller->image)}}" alt="{{$seller->stock}}" width="45px" height="45px"></td>
                                    <td>{{$seller->name}}</td>
                                    <td>{{$seller->stock}}</td>
                                    <td>{{$seller->email}}</td>
                                    <td>{{$seller->plan->name}}</td>
                                    <td>{{$seller->plan_starting_date}}</td>
                                    <td>
                                        @if($seller->status === 'unblocked')
                                            <span class="badge badge-success" style="background-color: seagreen">Active</span>
                                        @else
                                            <span class="badge badge-danger" style="background-color: #d73925; ">Blocked</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($seller->is_best_seller)
                                            <span class="badge badge-success" style="background-color: seagreen">Best Seller</span>
                                        @else
                                            <span class="badge badge-danger" style="background-color: #d73925; ">Not</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" onclick="RemoveItem('item-block-{{$seller->id}}','Do You Sure To (un) Block This Seller?')"> <i class="fa fa-ban"></i>   @if($seller->status === 'unblocked') Block @else Un Block @endif  </button>
                                        <button class="btn btn-sm btn-success" onclick="RemoveItem('item-best-{{$seller->id}}','Do You Sure To (un) Mark As Best Seller?')"> <i class="fa fa-check"></i>  @if($seller->is_best_seller) Mark As A Normal Seller @else Mark As A Best Seller  @endif   </button>
                                        <a href="{{route('seller.products',$seller->id)}}" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i>  View Products </a>
                                    </td>
                                    <form action="{{route('seller.update.status',$seller->id)}}" id="item-block-{{$seller->id}}" method="POST">@csrf @method('PUT')
                                        <input type="hidden" name="id" value="{{$seller->id}}"></form>
                                    <form action="{{route('seller.update.selling',$seller->id)}}" id="item-best-{{$seller->id}}" method="POST">@csrf @method('PUT')
                                        <input type="hidden" name="id" value="{{$seller->id}}"></form>
                                </tr>
                            @endforeach
                            </tbody></table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {{ $sellers->appends(request()->query())->links() }}
                        </ul>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection
