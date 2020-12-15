@extends('layouts.frontend-master')
@section('content')
    <!-- Start Bradcaump area -->
    <div class="ht__bradcaump__area bg-image--4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Checkout</h2>
                        <nav class="bradcaump-content">
                            <a class="breadcrumb_item" href="{{route('website')}}">Home</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb_item active">Checkout</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bradcaump area -->
    <!-- Start Checkout Area -->
    <section class="wn__checkout__area section-padding--lg bg__white">
        <div class="container">

            <div class="row">
                <div class="col-lg-6 col-12">
                    @if(session('message'))
                        <div class="alert alert-{{session('message')['type']}}"><b>Thanks .</b>{{session('message')['content']}}</div>
                    @endif
                    <div class="customer_details">
                        <h3>Billing Details</h3>
                        <span class="text-danger"> @error('plan')* {{$message}} @enderror</span>
                        <form action="{{route('checkout.plan',$plan->id)}}" method="POST" id="completeTheTransaction">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{$plan->id}}">
                            <input type="hidden" name="tmp_key" id="temporary_key">
                            <div class="customar__field">
                                <div class="margin_between">
                                    <div class="input_box space_between">
                                        <label>First name <span>*</span></label>
                                        <input name="first_name" type="text" value="{{old('first_name')}}">
                                       <span class="text-danger"> @error('first_name') {{$message}} @enderror</span>
                                    </div>
                                    <div class="input_box space_between">
                                        <label>last name <span>*</span></label>
                                        <input name="last_name" type="text" value="{{old('last_name')}}">
                                        <span class="text-danger"> @error('last_name') {{$message}} @enderror</span>
                                    </div>
                                </div>
                                <div class="input_box">
                                    <label>Country<span>*</span></label>
                                    <select class="select__option" name="country">
                                        <option selected disabled>Select a country…</option>
                                        @foreach(countries() as $country)
                                            <option value="{{$country->name}}" @if(old('country') == $country->name) selected @endif>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">  @error('country') {{$message}} @enderror</span>
                                </div>
                                <div class="margin_between">
                                    <div class="input_box space_between">
                                        <label>Company name <span>*</span></label>
                                        <input name="company" type="text" value="{{old('company')}}">
                                        <span class="text-danger"> @error('company') {{$message}} @enderror</span>
                                    </div>
                                    <div class="input_box space_between">
                                        <label>City <span>*</span></label>
                                        <input name="city" type="text" value="{{old('city')}}">
                                        <span class="text-danger">  @error('city') {{$message}} @enderror</span>
                                    </div>
                                </div>
                                <div class="margin_between">
                                <div class="input_box space_between">
                                    <label>Address <span>*</span></label>
                                    <input name="address" type="text"  value="{{old('address')}}">
                                    <span class="text-danger"> @error('address') {{$message}} @enderror</span>
                                </div>
                                    <div class="input_box space_between" >
                                        <label>Postcode / ZIP <span>*</span></label>
                                        <input name="postcode" type="text" value="{{old('postcode')}}">
                                        <span class="text-danger">   @error('postcode') {{$message}} @enderror</span>
                                    </div>

                                </div>

                                <div class="margin_between">
                                    <div class="input_box space_between">
                                        <label>Phone <span>*</span></label>
                                        <input name="phone" type="text" value="{{old('phone')}}">
                                        <span class="text-danger">  @error('phone') {{$message}} @enderror</span>
                                    </div>

                                    <div class="input_box space_between">
                                        <label>Email address <span>*</span></label>
                                        <input name="email" type="email" value="{{old('email')}}">
                                        <span class="text-danger"> @error('email') {{$message}} @enderror</span>
                                    </div>
                                </div>
                                <div class="input_box">
                                    <label>Payment Method<span>*</span></label>
                                    <select class="select__option" name="gateway">
                                        <option value="cod">Cache On Delivery</option>
                                        <option value="gateway">Gateway</option>
                                    </select>
                                    <span class="text-danger">  @error('gateway') {{$message}} @enderror</span>
                                </div>
                                @auth
                                    @if(is_null(auth()->user()->plan_id))
                                        <div class="input_box">
                                            <button type="submit" class="btn btn-warning checkout__btn">Complete The Transaction</button>
                                        </div>
                                    @endif
                                @endauth
                                @guest
                                    <div class="input_box">
                                        <a href="{{route('login')}}" class="btn btn-warning checkout__btn">Complete The Transaction</a>
                                    </div>
                                @endguest
                            </div>
                        </form>
                        @auth
                            @if(!is_null(auth()->user()->plan_id))
                                <div class="input_box">
                                    <button onclick="sureTheTransaction()" class="btn btn-warning checkout__btn">Complete The Transaction</button>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
                <div class="col-lg-6 col-12 md-mt-40 sm-mt-40">
                    <div class="wn__order__box">
                        <h3 class="onder__title">Your Plan</h3>
                        <ul class="order__total">
                            <li>Plan</li>
                            <li>Price</li>
                        </ul>
                        <ul class="order_product">
                            <li>{{$plan->name}}<span>${{$plan->price}}</span></li>
                        </ul>
                        <ul class="total__amount">
                            <li>Total <span>${{$plan->price}}</span></li>
                        </ul>
                    </div>
                    <div id="accordion" class="checkout_accordion mt--30" role="tablist">
                        <div class="payment">
                            <div class="che__header" role="tab" id="headingThree">
                                <a class="collapsed checkout__title" data-toggle="collapse" href="#collapseThree"
                                   aria-expanded="false" aria-controls="collapseThree">
                                    <span>Cash on Delivery</span>
                                </a>
                            </div>
                            <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree"
                                 data-parent="#accordion">
                                <div class="payment-body">Pay with cash upon delivery.</div>
                            </div>
                        </div>
                        <div class="payment">
                            <div class="che__header" role="tab" id="headingFour">
                                <a class="collapsed checkout__title" data-toggle="collapse" href="#collapseFour"
                                   aria-expanded="false" aria-controls="collapseFour">
                                    <span>PayPal <img src="{{frontAssets('images/icons/payment.png')}}" alt="payment images"> </span>
                                </a>
                            </div>
                            <div id="collapseFour" class="collapse" role="tabpanel" aria-labelledby="headingFour"
                                 data-parent="#accordion">
                                <div class="payment-body">Pay with cash upon delivery.</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- End Checkout Area -->
@endsection
