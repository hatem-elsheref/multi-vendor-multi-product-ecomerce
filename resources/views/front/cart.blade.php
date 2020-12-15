@extends('layouts.frontend-master')
@section('content')
    <!-- Start Bradcaump area -->
    <div class="ht__bradcaump__area bg-image--3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Shopping Cart</h2>
                        <nav class="bradcaump-content">
                            <a class="breadcrumb_item" href="{{route('website')}}">Home</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb_item active">Shopping Cart</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bradcaump area -->
    <!-- cart-main-area start -->
    <div class="cart-main-area section-padding--lg bg--white">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 ol-lg-12">
                    <form action="{{route('cart.update')}}" method="post" id="update-cart-form">
                        @csrf
                        <div class="table-content wnro__table table-responsive">
                            <table>
                                <thead>
                                <tr class="title-top">
                                    <th class="product-thumbnail">Image</th>
                                    <th class="product-name">Product</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-subtotal">Total</th>
                                    <th class="product-remove">Remove</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($cart->getItems() as $item)
                                    <tr>
                                        <td class="product-thumbnail"><a href="{{route('product.details',$item->slug)}}"><img src="{{$item->image}}" style="width: 80px;height: 80px" alt="product img {{$item->name}}"></a></td>
                                        <td class="product-name"><a href="{{route('product.details',$item->slug)}}">{{$item->name}}</a></td>
                                        <td class="product-price"><span class="amount">${{$item->price}}</span></td>
                                        <input type="hidden" >
                                        <td class="product-quantity"><input type="number" min="1" step="1" name="product[{{$item->id}}]" value="{{$item->qty}}"></td>
                                        <td class="product-subtotal">${{$item->qty * $item->price}}</td>
                                        <td class="product-remove"><a href="{{route('cart.remove',$item->slug)}}">X</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="cartbox__btn">
                        <ul class="cart__btn__list d-flex flex-wrap flex-md-nowrap flex-lg-nowrap justify-content-between">
                            <li><a href="javascript:void(0)" onclick="document.getElementById('update-cart-form').submit()">Update Cart</a></li>
                            <li><a href="{{route('cart.checkout.view')}}">Check Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 offset-lg-6">
                    <div class="cartbox__total__area">
                        <div class="cartbox-total d-flex justify-content-between">
                            <ul class="cart__total__list">
                                <li>Cart total</li>
                            </ul>
                            <ul class="cart__total__tk">
                                <li>${{$cart->getTotalPrice()}}</li>
                            </ul>
                        </div>
                        <div class="cart__total__amount">
                            <span>Grand Total</span>
                            <span>$1{{$cart->getTotalPrice()}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart-main-area end -->
@endsection
