@extends('layouts.frontend-master')
@section('content')
    <!-- Start Bradcaump area -->
    <div class="ht__bradcaump__area bg-image--4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Trace System</h2>
                        <nav class="bradcaump-content">
                            <a class="breadcrumb_item" href="{{route('website')}}">Home</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb_item active">Trace</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bradcaump area -->
    <!-- Start Faq Area -->
    <section class="wn__faq__area bg--white pt--80 pb--60">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if(session('response'))
                        <div class="alert alert-{{session('response')['type']}}">{{session('response')['message']}}</div>
                    @endif
                    <div class="wn__accordeion__content">
                        <form action="{{route('trace.search')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-11">
                                    <input type="text" name="code" value="{{old('code')??$order->trace_code??''}}" placeholder="Ex:ABC_ " class="form-control">
                                </div>
                                <div class="col-lg-1">
                                    <button type="submit" class="btn btn-dark form-control">  <i class="bi bi-search"></i></button>
                                </div>
                            </div>
                        </form>

                    </div>
                  @if(isset($order) and !empty($order))
                        <div id="accordion" class="wn_accordion" role="tablist">
                            <div class="card">
                                <div class="acc-header" role="tab" id="headingOne">
                                    <h5>
                                        <a data-toggle="collapse" href="#collapseOne" role="button" aria-expanded="true" aria-controls="collapseOne">
                                            Your Order Items (Total : {{$order->total}} $)
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <td>Product</td>
                                                <td>Quantity</td>
                                                <td>Total</td>
                                                <td>Payment Method</td>
                                                <td>Status</td>
                                                <td>Start Date</td>
                                                @if($order->status == SHIPPED)
                                                <td>Arriving Date</td>
                                                @endif
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($order->items as $item)
                                                <tr>
                                                    <td><a href="{{route('product.details',$item->product->slug)}}">{{$item->product->name}}</a></td>
                                                    <td>{{$item->quantity}}</td>
                                                    <td>{{$item->quantity*$item->product->price}} $</td>
                                                    <td>{{$order->method}}</td>
                                                    <td>{{$order->status}}</td>
                                                    <td>{{$order->created_at->format('Y-m-d h:i')}}</td>
                                                    @if($order->status == SHIPPED)
                                                    <td>{{$order->created_at->addDays($order->shipping_time)}}</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="contact-form-wrap">
                                @if($errors->any())
                                    @foreach($errors->all() as $error)
                                        <p class="alert alert-danger">* {{$error}}</p>
                                    @endforeach
                                @endif
                                @if(session('response'))
                                    <div class="alert alert-{{session('response')['type']}}">{{session('response')['message']}}</div>
                                @endif
                                <h2 class="contact__title">Send To Seller</h2>
                                <form  action="{{route('contact.seller')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="order" value="{{$order->id}}">
                                    <div class="single-contact-form space-between">
                                        <input type="email" name="email" placeholder="Email*" value="{{old('email')}}">
                                        <input type="text" name="subject" placeholder="Subject*" value="{{old('subject')}}">
                                    </div>

                                    <div class="single-contact-form message">
                                        <textarea name="message" placeholder="Type your message here..">{{old('message')}}</textarea>
                                    </div>
                                    <div class="contact-btn">
                                        <button type="submit">Send Email</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                      @endif
                </div>
            </div>
        </div>
    </section>
    <!-- End Faq Area -->
    @endsection
