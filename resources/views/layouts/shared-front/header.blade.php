<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Home | Bookshop Responsive Bootstrap4 Template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{frontAssets('images/favicon.ico')}}">
    <link rel="apple-touch-icon" href="{{frontAssets('images/icon.png')}}">

    <!-- Google font (font-family: 'Roboto', sans-serif; Poppins ; Satisfy) -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,600,600i,700,700i,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{frontAssets('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{frontAssets('css/plugins.css')}}">
    <link rel="stylesheet" href="{{frontAssets('css/style.css')}}">

    <!-- Cusom css -->
    <link rel="stylesheet" href="{{frontAssets('css/custom.css')}}">

    @yield('cs')
    <!-- Modernizer js -->
    <script src="{{frontAssets('js/vendor/modernizr-3.5.0.min.js')}}"></script>
</head>
<body>
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->
@include('sweetalert::alert')
<!-- Main wrapper -->
<div class="wrapper" id="wrapper">
    <!-- Header -->
    <header id="wn__header" class="{{request()->route()->getName() =='website'?'':'oth-page'}} header__area header__absolute sticky__header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-6 col-lg-2">
                    <div class="logo">
                        <a href="{{route('website')}}">
                            <img src="{{frontAssets('images/logo/'.config('general.logo'))}}" width="50px" height="50px" alt="logo">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8 d-none d-lg-block">
                    <nav class="mainmenu__nav">
                        <ul class="meninmenu d-flex justify-content-start">
                            <li class="drop with--one--item"><a href="{{route('website')}}">Home</a></li>
                            <li class="drop with--one--item"><a href="{{route('shop')}}">Shop</a></li>
                            <li class="drop"><a href="#">Categories</a>
                                <div class="megamenu dropdown">
                                    <ul class="item item01">
                                        @foreach($categories as $category)
                                            <li><a href="{{route('category.search',$category->name)}}">{{$category->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            <li><a href="{{route('trace')}}">Trace</a></li>
                            <li><a href="{{route('about')}}">About</a></li>
                            <li><a href="{{route('contact')}}">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-6 col-6 col-lg-2">
                    <ul class="header__sidebar__right d-flex justify-content-end align-items-center">
                        <li class="shop_search"><a class="search__active" href="#"></a></li>
                        <li class="setting__bar__icon"><a class="setting__active" href="#"></a>
                            <div class="searchbar__content setting__block">
                                <div class="content-inner">
                                    <div class="switcher-currency">
                                        <strong class="label switcher-label">
                                            <span>My Account</span>
                                        </strong>
                                        <div class="switcher-options">
                                            <div class="switcher-currency-trigger">
                                                <div class="setting__menu">
                                                    @auth
                                                        <span><a href="{{route('account')}}">My Account</a></span>
                                                        @if(auth()->user()->role != CUSTOMER)
                                                            <span><a href="{{route('dashboard')}}">Dashboard</a></span>
                                                        @endif
                                                        <span><a href="{{ route('logout') }}"
                                                           onclick="event.preventDefault();
                                                               document.getElementById('logout-form').submit();">Logout</a></a>
                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
                                                        </span>
                                                    @endauth
                                                    @guest
                                                        <span><a href="{{route('login')}}">Sign In</a></span>
                                                        <span><a href="{{route('register')}}">Create An Account</a></span>
                                                    @endguest
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="shopcart"><a class="cartbox_active" href="#"><span class="product_qun">{{$cart->getTotalItems()}}</span></a>
                            <!-- Start Shopping Cart -->
                            <div class="block-minicart minicart__active">
                                <div class="minicart-content-wrapper">
                                    <div class="micart__close">
                                        <span>close</span>
                                    </div>
                                    <div class="items-total d-flex justify-content-between">
                                        <span>{{$cart->getTotalItems()}} items</span>
                                        <span>Cart Subtotal</span>
                                    </div>
                                    <div class="total_amount text-right">
                                        <span>${{$cart->getTotalPrice()}}</span>
                                    </div>
                                    <div class="mini_action checkout">
                                        <a class="checkout__btn" href="{{route('cart.checkout.view')}}">Go to Checkout</a>
                                    </div>
                                    <div class="single__items">
                                        <div class="miniproduct">
                                            @php
                                            $count=1;
                                            @endphp
                                            @foreach($cart->getItems() as $item)
                                                @if($count>3)
                                                    @break
                                                    @else
                                                    @php
                                                        $count++;
                                                    @endphp
                                                @endif
                                                <div class="item01 d-flex @if(!$loop->first) mt--20 @endif">
                                                    <div class="thumb">
                                                        <a href="{{route('product.details',$item->slug)}}"><img src="{{$item->image}}" alt="product images {{$item->name}}"></a>
                                                    </div>
                                                    <div class="content">
                                                        <h6><a href="{{route('product.details',$item->slug)}}">{{$item->name}}</a></h6>
                                                        <span class="prize">${{$item->price}}</span>
                                                        <div class="product_prize d-flex justify-content-between">
                                                            <span class="qun">Qty: {{$item->qty}}</span>
                                                            <ul class="d-flex justify-content-end">
                                                                <li><a href="{{route('cart.remove',$item->slug)}}"><i class="zmdi zmdi-delete"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                    <div class="mini_action cart">
                                        <a class="cart__btn" href="{{route('cart.view')}}">View and edit cart</a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Shopping Cart -->
                        </li>

                    </ul>
                </div>
            </div>
            <!-- Start Mobile Menu -->
            <div class="row d-none">
                <div class="col-lg-12 d-none">
                    <nav class="mobilemenu__nav">
                        <ul class="meninmenu">
                            <li><a href="{{route('website')}}">Home</a></li>
                            <li><a href="{{route('shop')}}">Shop</a></li>
                            <li><a href="#">Categories</a>
                                <ul>
                                    @foreach($categories as $category)
                                        <li><a href="{{route('category.search',$category->name)}}">{{$category->name}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="{{route('trace')}}">Trace</a></li>
                            <li><a href="{{route('about')}}">About</a></li>
                            <li><a href="{{route('contact')}}">Contact</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- End Mobile Menu -->
            <div class="mobile-menu d-block d-lg-none">
            </div>
            <!-- Mobile Menu -->
        </div>
    </header>
    <!-- //Header -->
    <!-- Start Search Popup -->
    <div class="{{request()->route()->getName() =='website'?'brown--color':''}} box-search-content search_active block-bg close__top">
        <form id="search_mini_form" class="minisearch" action="{{route('keyword.search')}}">
            <div class="field__search">
                <input type="text" name="q" placeholder="Search entire store here...">
                <div class="action">
                    <a href="javascript:void(0)" type="submit" onclick="document.getElementById('search_mini_form').submit()"><i class="zmdi zmdi-search"></i></a>
                </div>
            </div>
        </form>
        <div class="close__wrap">
            <span>close</span>
        </div>
    </div>
    <!-- End Search Popup -->


