@extends('layouts.backend-master')
@section('bread')
    <h1>All Products</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Products</li>
    </ol>
@endsection
@section('content')
    <section>
        <div class="row">

            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Products <span class="badge badge-success">{{$products->total()}}</span></h3>
                        <div class="box-tools">

                            <form action="{{($products->total() > 0)?route('seller.products',$products->first()->stock->id):'#'}}" method="get">
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
                                <th>Stock</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Model</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Stars</th>
                                <th>Image</th>
                                <th>view</th>
                            </tr>
                            @forelse($products as $product)
                                <tr>
                                    <td>{{$product->id}}</td>
                                    <td>{{$product->stock->stock}}</td>
                                    <td>{{$product->category->name}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->model}}</td>
                                    <td>{{$product->qty}}</td>
                                    <td>{{$product->price}}</td>
                                    <td>({{$product->quality_rate}})
                                        @for($i=0;$i<$product->quality_rate;$i++)
                                            <i class="fa fa-star" style="color: orange"></i>
                                        @endfor
                                        @for($i=0;$i<5-$product->quality_rate;$i++)
                                            <i class="fa fa-star" style="color: silver"></i>
                                        @endfor
                                    </td>
                                    <td><img class="img-circle" src="{{$product->mainImage()}}" alt="{{$product->slug}}" width="45px" height="45px"></td>
                                    <td>
                                        <a href="{{route('products.show',$product->slug)}}" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i>  View </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="9"> <h5 class="text-bold">No Products Founded...</h5></td>
                                </tr>
                            @endforelse
                            </tbody></table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {{ $products->appends(request()->query())->links() }}
                        </ul>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection
