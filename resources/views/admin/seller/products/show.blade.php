@extends('layouts.backend-master')
@section('bread')
    <h1>Product Details</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{route((auth()->user()->role === ADMIN)?'products.all':'product.index')}}"><i class="fa fa-product-hunt"></i> Products</a></li>
        <li class="active">Details</li>
    </ol>
@endsection
@section('content')
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{$product->name}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                   <div class="row">
                       <div class="col-sm-12 col-md-4">

                           <div class="mailbox-read-message">
                               <p class="text-bold"> <i class="fa fa-check text-success"></i> Description</p>
                               <p>{!! $product->description !!}</p>

                           </div>
                       </div>
                       <div class="col-sm-12 col-md-8">
                           {{-- IMAGES  --}}
                           <p class="text-bold"> <i class="fa fa-check text-success"></i> Images</p>
                           <ul class="mailbox-attachments clearfix">
                               @foreach($product->images as $image)
                                   <li>
                                       <span class="mailbox-attachment-icon has-img"><img src="{{uploadedAssets($image->src)}}" style="height: 200px" alt="{{$product->slug}}"></span>
                                       <div class="mailbox-attachment-info">
                                           <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> image ({{$loop->index}})</a>
{{--                                           <span class="mailbox-attachment-size">{{round(\Illuminate\Support\Facades\Storage::disk('my_desk')->size($image->src)/1000/1000,2)}} MB</span>--}}
                                       </div>
                                   </li>
                               @endforeach
                           </ul>
                           {{-- PRICE - quantity - category - stock --}}
                           <div class="mailbox-read-message">
                               <p class="text-bold"><i class="fa fa-check text-success"></i> Name  <span class="badge badge-primary" style="background-color: #0c5460" >{{$product->name}} </span></p>
                               <p class="text-bold"><i class="fa fa-check text-success"></i> Model  <span class="badge badge-primary" style="background-color: #0c5460" >{{$product->model}} </span></p>
                               <p class="text-bold"><i class="fa fa-check text-success"></i> Price  <span class="badge badge-primary" style="background-color: #0c5460" >{{$product->price}} $</span></p>
                               <p class="text-bold"><i class="fa fa-check text-success"></i> Quantity  <span class="badge badge-primary" style="background-color: #0c5460" >{{$product->qty}}</span></p>
                               <p class="text-bold"><i class="fa fa-check text-success"></i> Category  <span class="badge badge-darK" style="background-color: #0c5460" >{{$product->category->name}}</span></p>
                               <p class="text-bold"><i class="fa fa-check text-success"></i> Stock  <span class="badge badge-darK" style="background-color: #0c5460" >{{$product->stock->stock}}</span></p>

                           </div>
                           {{-- COLORS  --}}
                           <div class="mailbox-read-message">
                               <p class="text-bold"><i class="fa fa-check text-success"></i> Colors</p>
                               @if(!is_null($product->colors))
                                   @foreach(unserialize($product->colors) as $color)
                                       <span><i style="color: {{colorsAvailable()[$color]}}" class="fa fa-square fa-2x"></i></span>
                                   @endforeach
                               @else
                                   <span  class="text-bold"> no colors selected yet ..</span>
                               @endif
                           </div>
                           {{-- SIZES  --}}
                           <div class="mailbox-read-message">
                               <p class="text-bold"><i class="fa fa-check text-success"></i> Sizes     @if(!is_null($product->sizes)) <span class="badge badge-primary" style="background-color: #0c5460" >{{unserialize($product->sizes)['class']}}</span> @endif</p>
                               @if(!is_null($product->sizes))
                                   @foreach(unserialize($product->sizes)['sizes'] as $size)
                                       <span class="badge badge-darK" >{{$size}}</span>
                                   @endforeach
                               @else
                                   <span  class="text-bold"> no colors selected yet ..</span>
                               @endif
                           </div>
                           <!-- /.mailbox-read-message -->
                       </div>
                   </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                    </div>
                    <!-- /.box-footer -->
                    <div class="box-footer">
                        <div class="pull-right">
                            <a href="{{route((auth()->user()->role === ADMIN)?'products.all':'product.index')}}" class="btn btn-primary"><i class="fa fa-reply"></i> Back</a>
                        </div>

                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /. box -->
            </div>
            </div>
        </div>
    </section>
@endsection
