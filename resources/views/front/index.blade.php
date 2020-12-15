@extends('layouts.frontend-master')
@section('content')
@include('layouts.shared-front.slider')

    <!-- Start BEst Seller Area -->
    <section class="wn__product__area brown--color pt--80  pb--30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section__title text-center">
                        <h2 class="title__be--2">New <span class="color--theme">Products</span></h2>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered lebmid alteration in some ledmid form</p>
                    </div>
                </div>
            </div>
            <!-- Start Single Tab Content -->
            <div class="furniture--4 border--round arrows_style owl-carousel owl-theme row mt--50">
                @foreach($products as $product)
                    <!-- Start Single Product -->
                        <div class="product product__style--3">
                            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                <div class="product__thumb">
                                    <a class="first__img" href="{{route('product.details',$product->slug)}}"><img src="{{uploadedAssets($product->images[0]->src)}}" alt="product image"></a>
                                    <a class="second__img animation1" href="{{route('product.details',$product->slug)}}"><img src="{{uploadedAssets($product->images[1]->src)}}" alt="product image"></a>

                                    @if($product->stock->is_best_seller)
                                        <div class="hot__box">
                                            <span class="hot-label">BEST SALER</span>
                                        </div>
                                        @endif
                                </div>
                                <div class="product__content content--center content--center">
                                    <h4><a href="{{route('product.details',$product->slug)}}">{{$product->name}}</a></h4>
                                    <ul class="prize d-flex">
                                        <li>${{$product->price}}</li>
{{--                                        <li class="old_prize">${{(($product->price*10)/100)+$product->price}}</li>--}}
                                        <li class="text-dark">{{ucfirst(str_replace('-',' ',$product->stock->stock))}}</li>
                                    </ul>
                                    <div class="action">
                                        <div class="actions_inner">
                                            <ul class="add_to_links">
                                                <li><a class="cart" href="{{route('cart.add',$product->slug)}}"><i class="bi bi-shopping-bag4"></i></a></li>
                                                <li><a data-toggle="modal" title="Quick View" class="quickview modal-view detail-link" href="#productmodal-new-{{$product->id}}"><i class="bi bi-search"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product__hover--content">
                                            {{--here--}}
                                        <ul class="rating d-flex">
                                            @for($i=0;$i<$product->quality_rate;$i++)
                                                <li class="on"><i class="fa fa-star"></i></li>
                                            @endfor
                                            @for($i=0;$i<5-$product->quality_rate;$i++)
                                                <li><i class="fa fa-star-o"></i></li>
                                            @endfor
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Start Single Product -->
                        </div>

                    @endforeach
            </div>
            <!-- End Single Tab Content -->
        </div>
    </section>
    <!-- Start BEst Seller Area -->
    <!-- Start NEwsletter Area -->
    <section class="wn__newsletter__area bg-image--2">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 offset-lg-5 col-md-12 col-12 ptb--150">
                    <div class="section__title text-center">
                        <h2>Stay With Us</h2>
                    </div>
                    <div class="newsletter__block text-center">
                        <p>Subscribe to our newsletters now and stay up-to-date with new collections, the latest lookbooks and exclusive offers.</p>
                        <form action="{{route('news_letter')}}" method="POST">
                            @csrf
                            <div class="newsletter__box">
                                <input type="email" name="email" placeholder="Enter your e-mail" value="{{old('email')}}">
                               @error('email')  <span class="text-danger text-bold">* {{$message}}</span> @enderror
                                <button type="submit">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End NEwsletter Area -->
    <!-- Start Best Seller Area -->
    <section class="wn__bestseller__area bg--white pt--80  pb--30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section__title text-center">
                        <h2 class="title__be--2">All <span class="color--theme">Products</span></h2>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered lebmid alteration in some ledmid form</p>
                    </div>
                </div>
            </div>
            <div class="row mt--50">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="product__nav nav justify-content-center" role="tablist">
                    @foreach($latestCategories  as $category)
                            <a class="nav-item nav-link @if($loop->first) active @endif" data-toggle="tab" href="#nav-{{$category->name}}" role="tab">{{$category->name}}</a>
                    @endforeach
                    </div>
                </div>
            </div>
            <div class="tab__container mt--60">
                @foreach($latestCategories as $category)
                    <!-- Start Single Tab Content -->
                        <div class="row single__tab tab-pane @if($loop->first) active @endif " id="nav-{{$category->name}}" role="tabpanel">
                            <div class="product__indicator--4 arrows_style owl-carousel owl-themes">
                               @foreach($category->products as $product)
                                    @if($loop->index > 10 ) @break
                                    @else
                                        <div class="single__product">
                                        <!-- Start Single Product -->
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                            <div class="product product__style--3">
                                                <div class="product__thumb">
                                                    <a class="first__img" href="{{route('product.details',$product->slug)}}"><img src="{{uploadedAssets($product->images[0]->src)}}" alt="product image {{$product->name}}"></a>
                                                    <a class="second__img animation1" href="{{route('product.details',$product->slug)}}"><img src="{{uploadedAssets($product->images[1]->src)}}" alt="product image {{$product->name}}"></a>

                                                @if($product->stock->is_best_seller)
                                                        <div class="hot__box">
                                                            <span class="hot-label">BEST SELLER</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="product__content content--center">
                                                    <h4><a href="{{route('product.details',$product->slug)}}">{{$product->name}}</a></h4>
                                                    <ul class="prize d-flex">
                                                        <li>${{$product->price}}</li>
                                                        {{--                                        <li class="old_prize">${{(($product->price*10)/100)+$product->price}}</li>--}}
                                                        <li class="text-dark">{{ucfirst(str_replace('-',' ',$product->stock->stock))}}</li>
                                                    </ul>
                                                    <div class="action">
                                                        <div class="actions_inner">

                                                            <ul class="add_to_links">
                                                                <li><a class="cart" href="{{route('cart.add',$product->slug)}}"><i class="bi bi-shopping-bag4"></i></a></li>
                                                                <li><a data-toggle="modal" title="Quick View" class="quickview modal-view detail-link" href="#productmodal-all-{{$product->id}}"><i class="bi bi-search"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product__hover--content">
                                                        <ul class="rating d-flex">
                                                            @for($i=0;$i<$product->quality_rate;$i++)
                                                                <li class="on"><i class="fa fa-star"></i></li>
                                                            @endfor
                                                            @for($i=0;$i<5-$product->quality_rate;$i++)
                                                                <li><i class="fa fa-star-o"></i></li>
                                                            @endfor
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Start Single Product -->
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                        <!-- End Single Tab Content -->
                 @endforeach
            </div>
        </div>
    </section>
    <!-- Start BEst Seller Area -->
    <!-- Start Recent Post Area -->
    <section class="wn__recent__post bg--gray ptb--80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section__title text-center">
                        <h2 class="title__be--2">Our <span class="color--theme">Plans</span></h2>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered lebmid alteration in some ledmid form</p>
                    </div>
                </div>
            </div>
            <div class="row mt--50">
                @foreach($plans as $plan)
                    <div class="col-md-6 col-lg-4 col-sm-12">
                        <div class="post__itam">
                            <div class="content">
                                <h3 class="text-center" style="text-transform: uppercase">{{$plan->name}} </h3>
                                <div class="post__time" style="padding-top: unset">
                                    <div class="minicart-content-wrapper" style="width: 285px;padding: unset">
                                        <div class="mini_action checkout">
                                            <a class="checkout__btn" href="{{route('checkout.plan.show',$plan->id)}}">Subscribe </a>
                                        </div>
                                    </div>
                                    <div class="post__time">
                                        <span><a href="javascript:void (0)" style="color: #777777" ><i class="bi bi-money-bag" style="color:#e59285"></i> ${{$plan->price}}</a></span>

                                        <div class="post-meta">
                                            <ul>
                                                <li><a href="javascript:void(0)"><i class="bi bi-refresh-time"></i>{{$plan->period}} Month(s)</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Recent Post Area -->
    <!-- Best Sale Area -->
    <section class="best-seel-area pt--80 pb--60" id="best_seller">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section__title text-center pb--50">
                        <h2 class="title__be--2">Best <span class="color--theme">Seller </span></h2>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered lebmid alteration in some ledmid form</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="slider center">
            @foreach($bestSellers as $seller)
                <!-- Single product start -->
                    <div class="product product__style--3">
                        <div class="product__thumb">
                            <a class="first__img" href="#"><img src="{{uploadedAssets($seller->image)}}" alt="{{$seller->stock}} image"></a>
                        </div>
                        <div class="product__content content--center">
                            <div class="action">
                                <div class="actions_inner">

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single product end -->
            @endforeach

        </div>
    </section>
    <!-- Best Sale Area Area -->

    <!-- QUICKVIEW PRODUCT -->
    <div id="quickview-wrapper">
    @foreach($products as $product)
        <!-- Modal -->
            <div class="modal fade" id="productmodal-new-{{$product->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal__container" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal__header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-product">
                                <!-- Start product images -->
                                <div class="product-images">
                                    <div class="main-image images">
                                        <img alt="big images" src="{{uploadedAssets($product->mainImage())}}" width="420px" height="619px">
                                    </div>
                                </div>
                                <!-- end product images -->
                                <div class="product-info">
                                    <h1>{{$product->name}}</h1>
                                    <div class="rating__and__review">
                                        <div class="review"></div>
                                    </div>
                                    <div class="price-box-3">
                                        <div class="s-price-box">
                                            <span class="new-price">${{$product->price}}</span>
                                        </div>
                                    </div>
                                    <div class="quick-desc">
                                        {!! $product->description !!}
                                    </div>

                                    <div class="select__size">
                                        <h2>Stock (seller)</h2>
                                        <ul class="color__list">
                                            <li class="l__size"><span>{{$product->stock->stock .' ('.$product->stock->name}})</span></li>
                                        </ul>
                                    </div>
                                    <div class="select__size">
                                        <h2>Model</h2>
                                        <ul class="color__list">
                                            <li class="l__size"><span>{{$product->model}}</span></li>
                                        </ul>
                                    </div>
                                    <div class="select__size">
                                        <h2>Category</h2>
                                        <ul class="color__list">
                                            <li class="l__size"><span>{{$product->category->name}}</span></li>
                                        </ul>
                                    </div>
                                    <div class="select__size">
                                        <h2>Quantity</h2>
                                        <ul class="color__list">
                                            @if($product->qty>0)
                                                <span></span>
                                                <li class="l__size"><span>{{$product->qty}}</span></li>
                                            @else
                                                <li class="l__size"> <span>Out Of The Stock</span></li>
                                            @endif

                                        </ul>
                                    </div>
                                    @if(!is_null($product->colors))
                                        <div class="select__color">
                                            <h2>Select color</h2>
                                            <ul class="color__list">
                                                @foreach(unserialize($product->colors) as $color)
                                                    @if($loop->index > 10 )
                                                        @break
                                                    @else
                                                        <li><a style="background:{{colorsAvailable()[$color]}};border:0.2px solid black" title="{{$color}}" href="#">{{$color}}</a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if(!is_null($product->sizes))
                                        <div class="select__size">
                                            <h2>Select size ( {{unserialize($product->sizes)['class']}} ) </h2>
                                            <ul class="color__list">
                                                <li class="badge    "></li>
                                                @foreach(unserialize($product->sizes)['sizes'] as $size)
                                                    @if($loop->index > 10 )
                                                        @break
                                                    @else
                                                        <li class="l__size"><a title="{{$size}}" href="#">{{$size}}</a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif


                                    <div class="addtocart-btn">
                                        <a href="{{route('cart.add',$product->slug)}}">Add to cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @foreach($latestCategories as $category)
             @foreach($category->products as $product)
        <!-- Modal -->
            <div class="modal fade" id="productmodal-all-{{$product->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal__container" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal__header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-product">
                                <!-- Start product images -->
                                <div class="product-images">
                                    <div class="main-image images">
                                        <img alt="big images" src="{{uploadedAssets($product->mainImage())}}" width="420px" height="619px">
                                    </div>
                                </div>
                                <!-- end product images -->
                                <div class="product-info">
                                    <h1>{{$product->name}}</h1>
                                    <div class="rating__and__review">
                                        <div class="review"></div>
                                    </div>
                                    <div class="price-box-3">
                                        <div class="s-price-box">
                                            <span class="new-price">${{$product->price}}</span>
                                        </div>
                                    </div>
                                    <div class="quick-desc">
                                        {!! $product->description !!}
                                    </div>

                                    <div class="select__size">
                                        <h2>Stock (seller)</h2>
                                        <ul class="color__list">
                                            <li class="l__size"><span>{{$product->stock->stock .' ('.$product->stock->name}})</span></li>
                                        </ul>
                                    </div>
                                    <div class="select__size">
                                        <h2>Model</h2>
                                        <ul class="color__list">
                                            <li class="l__size"><span>{{$product->model}}</span></li>
                                        </ul>
                                    </div>
                                    <div class="select__size">
                                        <h2>Category</h2>
                                        <ul class="color__list">
                                            <li class="l__size"><span>{{$product->category->name}}</span></li>
                                        </ul>
                                    </div>
                                    <div class="select__size">
                                        <h2>Quantity</h2>
                                        <ul class="color__list">
                                            @if($product->qty>0)
                                                <span></span>
                                                <li class="l__size"><span>{{$product->qty}}</span></li>
                                            @else
                                                <li class="l__size"> <span>Out Of The Stock</span></li>
                                            @endif

                                        </ul>
                                    </div>
                                    @if(!is_null($product->colors))
                                        <div class="select__color">
                                            <h2>Select color</h2>
                                            <ul class="color__list">
                                                @foreach(unserialize($product->colors) as $color)
                                                    @if($loop->index > 10 )
                                                        @break
                                                    @else
                                                        <li><a style="background:{{colorsAvailable()[$color]}};border:0.2px solid black" title="{{$color}}" href="#">{{$color}}</a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if(!is_null($product->sizes))
                                        <div class="select__size">
                                            <h2>Select size ( {{unserialize($product->sizes)['class']}} ) </h2>
                                            <ul class="color__list">
                                                <li class="badge    "></li>
                                                @foreach(unserialize($product->sizes)['sizes'] as $size)
                                                    @if($loop->index > 10 )
                                                        @break
                                                    @else
                                                        <li class="l__size"><a title="{{$size}}" href="#">{{$size}}</a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif


                                    <div class="addtocart-btn">
                                        <a href="{{route('cart.add',$product->slug)}}">Add to cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @endforeach
    </div>
    <!-- END QUICKVIEW PRODUCT -->
@endsection
