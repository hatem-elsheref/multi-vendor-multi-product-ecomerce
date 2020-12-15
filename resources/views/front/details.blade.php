@extends('layouts.frontend-master')
@section('cs')
    <link rel="stylesheet" href="{{frontAssets('css/stars.css')}}">
@endsection
@section('content')
    <!-- Start Bradcaump area -->
    <div class="ht__bradcaump__area bg-image--4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Shop</h2>
                        <nav class="bradcaump-content">
                            <a class="breadcrumb_item" href="{{route('website')}}">Home</a>
                            <span class="brd-separetor">/</span>
                                <span class="breadcrumb_item active">Product Details</span>

                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bradcaump area -->
    <!-- Start main Content -->
    <div class="maincontent bg--white pt--80 pb--55">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-12">
                    <div class="wn__single__product">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="wn__fotorama__wrapper">
                                    <div class="fotorama wn__fotorama__action" data-nav="thumbs">
                                        @foreach($product->images as $image)
                                            <a href="{{$image->src()}}"><img src="{{$image->src()}}" style="width: 450px;height: 565px" alt="{{$product->slug}}"></a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @php
                                $result=ifCustomerHasReview($product);
                            @endphp
                            <div class="col-lg-6 col-12">
                                <div class="product__info__main">
                                    <h1>{{$product->name}}</h1>
                                    <div class="product-reviews-summary d-flex">
                                        <ul class="rating-summary d-flex">
                                            @for($i=0;$i<$product->quality_rate;$i++)
                                                <li class="on"><i class="fa fa-star"></i></li>
                                            @endfor
                                            @for($i=0;$i<5-$product->quality_rate;$i++)
                                                    <li><i class="fa fa-star-o"></i></li>
                                            @endfor
                                        </ul>
                                    </div>
                                    <div class="price-box">
                                        <span>$ {{$product->price}}</span>
                                    </div>
                                    <div class="product__overview">
                                       <p>
                                           {!! $product->description !!}
                                       </p>
                                    </div>
                                    <form action="{{route('cart.add',$product->slug)}}" method="get">
                                    <div class="box-tocart d-flex">
                                            <span>Qty</span>
                                            <input id="qty" class="input-text qty" name="qty" min="1" max="{{$product->qty}}" value="1" title="Qty" type="number">
                                            <div class="addtocart__actions">
                                                <button class="tocart" type="submit" title="Add to Cart">Add to Cart</button>
                                            </div>
                                    </div>
                                    </form>





                                    <div class="product_meta">
											<span class="posted_in">Stock (Seller):
												<span>{{$product->stock->stock}} ({{$product->stock->name}})</span>
											</span>
                                    </div>
                                    <div class="product_meta">
											<span class="posted_in">Model:
												<span>{{$product->model}}</span>
											</span>
                                    </div>

                                    <div class="product_meta">
											<span class="posted_in">Category:
												<a href="{{route('category.search',$product->category->name)}}">{{$product->category->name}}</a>
											</span>
                                    </div>




                                    @if(!is_null($product->colors))
                                        <div class="product_meta">
											<span class="posted_in">Colors:
												 @foreach(unserialize($product->colors) as $color)
                                                    @if($loop->index > 10 )
                                                        @break
                                                    @else
                                                        <i class="fa fa-square" style="color:transparent;background:{{colorsAvailable()[$color]}}" title="{{$color}}" ></i>
                                                    @endif
                                                @endforeach
											</span>
                                        </div>
                                    @endif

                                    @if(!is_null($product->sizes))
                                        <div class="product_meta">
                                            	<span class="posted_in">Sizes: ( {{unserialize($product->sizes)['class']}} )
                                                     @foreach(unserialize($product->sizes)['sizes'] as $size)
                                                        @if($loop->index > 10 )
                                                            @break
                                                        @else
                                                            <span class="l__size"><i title="{{$size}}">{{$size}}</i></span>,
                                                        @endif
                                                    @endforeach
                                                </span>
                                        </div>
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <p class="alert alert-danger">{{$error}}</p>
                        @endforeach
                    @endif

                    <div class="product__info__detailed">
                        <div class="pro_details_nav nav justify-content-start" role="tablist">
                            <a class="nav-item nav-link active" data-toggle="tab" href="#nav-details" role="tab">Details</a>
                            <a class="nav-item nav-link" data-toggle="tab" href="#nav-review" role="tab">Reviews</a>
                        </div>
                        <div class="tab__container">
                            <!-- Start Single Tab Content -->
                            <div class="pro__tab_label tab-pane fade show active" id="nav-details" role="tabpanel">
                                <div class="description__attribute">
                                    {!! $product->description !!}
                                </div>
                            </div>
                            <!-- End Single Tab Content -->
                            <!-- Start Single Tab Content -->
                            <div class="pro__tab_label tab-pane fade" id="nav-review" role="tabpanel">
                                <div class="review__attribute">
                                    <h1>Customer Reviews</h1>
                                    <div class="review__ratings__type d-flex">
                                        <div class="review-ratings">
                                            <div class="rating-summary d-flex">
                                                <span class="mr-1">Quality</span>
                                                <ul class="rating d-flex">
                                                    @for($i=0;$i<$product->quality_rate;$i++)
                                                        <li class="on"><i class="fa fa-star"></i></li>
                                                    @endfor
                                                    @for($i=0;$i<5-$product->quality_rate;$i++)
                                                        <li><i class="fa fa-star-o"></i></li>
                                                    @endfor
                                                </ul>
                                            </div>
                                            <div class="rating-summary d-flex">
                                                <span class="" style="margin-right:20px">Price </span>
                                                <ul class="rating d-flex">
                                                    @for($i=0;$i<$product->price_rate;$i++)
                                                        <li class="on"><i class="fa fa-star"></i></li>
                                                    @endfor
                                                    @for($i=0;$i<5-$product->price_rate;$i++)
                                                        <li><i class="fa fa-star-o"></i></li>
                                                    @endfor
                                                </ul>
                                            </div>
                                            <div class="rating-summary d-flex">
                                                <span class="mr-3">value</span>
                                                <ul class="rating d-flex">
                                                    @for($i=0;$i<$product->value_rate;$i++)
                                                        <li class="on"><i class="fa fa-star"></i></li>
                                                    @endfor
                                                    @for($i=0;$i<5-$product->value_rate;$i++)
                                                        <li><i class="fa fa-star-o"></i></li>
                                                    @endfor
                                                </ul>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                               @auth
                                    <div class="review-fieldset">
                                        <h2>You're reviewing:</h2><br>
                                        <div class="review-field-ratings">
                                            <div class="product-review-table">
                                                <div class="review-field-rating d-flex">
                                                    <span>Quality</span>
                                                    <div  id="quality"></div>
                                                </div>
                                                <div class="review-field-rating d-flex">
                                                    <span>Price</span>
                                                    <div class="ml-3" id="price"></div>
                                                </div>
                                                <div class="review-field-rating d-flex">
                                                    <span>Value</span>
                                                    <div class="ml-2" id="value"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="{{route('product.rate',$product->id)}}" method="post" id="make_new_rate">
                                            @csrf
                                            @if($result === false)
                                            <input type="hidden" name="quality" id="quality_value">
                                            <input type="hidden" name="price" id="price_value">
                                            <input type="hidden" name="value" id="value_value">
                                            @else
                                                <input type="hidden" name="quality" id="quality_value" value="{{$result->quality_rate}}">
                                                <input type="hidden" name="price" id="price_value" value="{{$result->price_rate}}">
                                                <input type="hidden" name="value" id="value_value" value="{{$result->value_rate}}">
                                            @endif
                                            <div class="review_form_field">
                                                <div class="input__box">
                                                    <span>Your Review</span>
                                                    @if($result === false)
                                                        <input id="summery_field" type="text" name="summery" value="{{old('summery')}}">
                                                        @else
                                                         <input id="summery_field" type="text" name="summery" value="{{$result->summary}}">
                                                    @endif
                                                </div>
                                                <div class="review-form-actions">
                                                    <button onclick="return false" id="submit_review">Submit Review</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                               @endauth
                            </div>
                            <!-- End Single Tab Content -->
                        </div>
                    </div>
                    <div class="wn__related__product pt--80 pb--50">
                        <div class="section__title text-center">
                            <h2 class="title__be--2">Related Products</h2>
                        </div>
                        <div class="row mt--60">
                            <div class="productcategory__slide--2 arrows_style owl-carousel owl-theme">

                                @foreach($relatedProducts as $relatedProduct)
                                <!-- Start Single Product -->
                                <div class="product product__style--3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="product__thumb">
                                        <a class="first__img" href="{{route('product.details',$relatedProduct->slug)}}"><img src="{{uploadedAssets($relatedProduct->images[0]->src)}}" alt="product image {{$relatedProduct->name}}"></a>
                                        <a class="second__img animation1" href="{{route('product.details',$relatedProduct->slug)}}"><img src="{{uploadedAssets($relatedProduct->images[1]->src)}}" alt="product image {{$relatedProduct->name}}"></a>
                                        @if($product->stock->is_best_seller)
                                            <div class="hot__box">
                                                <span class="hot-label">BEST SELLER</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="product__content content--center">
                                        <h4><a href="{{route('product.details',$relatedProduct->slug)}}">{{$relatedProduct->name}}</a></h4>
                                        <ul class="prize d-flex">
                                            <li>${{$relatedProduct->price}}</li>
                                            <li class="text-dark">{{$relatedProduct->stock->stock}}</li>
                                        </ul>
                                        <div class="action">
                                            <div class="actions_inner">
                                                <ul class="add_to_links">
                                                    <li><a class="cart" href="{{route('cart.add',$relatedProduct->slug)}}"><i class="bi bi-shopping-bag4"></i></a></li>
                                                    <li><a data-toggle="modal" title="Quick View" class="quickview modal-view detail-link" href=#related-product-modal-{{$relatedProduct->id}}><i class="bi bi-search"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product__hover--content">
                                            <ul class="rating d-flex">
                                                @for($i=0;$i<$relatedProduct->quality_rate;$i++)
                                                    <li class="on"><i class="fa fa-star"></i></li>
                                                @endfor
                                                @for($i=0;$i<5-$relatedProduct->quality_rate;$i++)
                                                    <li><i class="fa fa-star-o"></i></li>
                                                @endfor
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                                <!-- End Single Product -->
                                @endforeach



                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                    <div class="shop__sidebar">
                        <aside class="wedget__categories poroduct--cat">
                            <h3 class="wedget__title">Product Categories</h3>
                            <ul>
                                @foreach($categories as $category)
                                    <li><a href="{{route('category.search',$category->name)}}">{{$category->name}} <span>({{$category->products->count()}})</span></a></li>
                                @endforeach
                            </ul>
                        </aside>
                        <aside class="wedget__categories pro--range">
                            <h3 class="wedget__title">Filter by price</h3>
                            <div class="content-shopby">
                                <div class="price_filter s-filter clear">
                                    <form action="{{route('price.search')}}" method="GET" id="form-price-filter">
                                        <div id="slider-range"></div>
                                        <div class="slider__range--output">
                                            <div class="price__output--wrap">
                                                <div class="price--output">
                                                    <span>Price :</span><input name="price" type="text" id="amount" readonly="">
                                                </div>
                                                <div class="price--filter">
                                                    <a href="javascript:void(0)" onclick="document.getElementById('form-price-filter').submit()">Filter</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End main Content -->
    <!-- QUICKVIEW PRODUCT -->
    <div id="quickview-wrapper">
    @foreach($relatedProducts as $relatedProduct)
        <!-- Modal -->
            <div class="modal fade" id="related-product-modal-{{$relatedProduct->id}}" tabindex="-1" role="dialog">
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
                                        <img alt="big images" src="{{uploadedAssets($relatedProduct->mainImage())}}" width="420px" height="619px">
                                    </div>
                                </div>
                                <!-- end product images -->
                                <div class="product-info">
                                    <h1>{{$relatedProduct->name}}</h1>
                                    <div class="rating__and__review">
                                        <div class="review"></div>
                                    </div>
                                    <div class="price-box-3">
                                        <div class="s-price-box">
                                            <span class="new-price">${{$relatedProduct->price}}</span>
                                        </div>
                                    </div>
                                    <div class="quick-desc">
                                        {!! $relatedProduct->description !!}
                                    </div>

                                    <div class="select__size">
                                        <h2>Stock (seller)</h2>
                                        <ul class="color__list">
                                            <li class="l__size"><span>{{$relatedProduct->stock->stock .' ('.$relatedProduct->stock->name}})</span></li>
                                        </ul>
                                    </div>
                                    <div class="select__size">
                                        <h2>Model</h2>
                                        <ul class="color__list">
                                            <li class="l__size"><span>{{$relatedProduct->model}}</span></li>
                                        </ul>
                                    </div>
                                    <div class="select__size">
                                        <h2>Category</h2>
                                        <ul class="color__list">
                                            <li class="l__size"><span>{{$relatedProduct->category->name}}</span></li>
                                        </ul>
                                    </div>
                                    <div class="select__size">
                                        <h2>Quantity</h2>
                                        <ul class="color__list">
                                            @if($relatedProduct->qty>0)
                                                <span></span>
                                                <li class="l__size"><span>{{$relatedProduct->qty}}</span></li>
                                            @else
                                                <li class="l__size"> <span>Out Of The Stock</span></li>
                                            @endif

                                        </ul>
                                    </div>
                                    @if(!is_null($relatedProduct->colors))
                                        <div class="select__color">
                                            <h2>Select color</h2>
                                            <ul class="color__list">
                                                @foreach(unserialize($relatedProduct->colors) as $color)
                                                    @if($loop->index > 10 )
                                                        @break
                                                    @else
                                                        <li><a style="background:{{colorsAvailable()[$color]}};border:0.2px solid black" title="{{$color}}" href="#">{{$color}}</a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if(!is_null($relatedProduct->sizes))
                                        <div class="select__size">
                                            <h2>Select size ( {{unserialize($relatedProduct->sizes)['class']}} ) </h2>
                                            <ul class="color__list">
                                                <li class="badge    "></li>
                                                @foreach(unserialize($relatedProduct->sizes)['sizes'] as $size)
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
                                        <a href="{{route('cart.add',$relatedProduct->slug)}}">Add to cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @endforeach
    </div>
    <!-- END QUICKVIEW PRODUCT -->
    @endsection
@section('js')
    <script src="{{frontAssets('js/stars.js')}}"></script>
    <script>
        $(function () {

            var quality = $("#quality").rateYo({
                fullStar:true
                @if(old('quality'))
                ,rating:'{{old("quality")}}'
                @elseif($result !== false)
                ,rating:'{{$result->quality_rate}}'
                @endif
            });
            var price = $("#price").rateYo({
                fullStar:true
                @if(old('price'))
                ,rating:'{{old("price")}}'
                @elseif($result !== false)
                ,rating:'{{$result->price_rate}}'
                @endif
            });
            var value = $("#value").rateYo({
                fullStar:true
                @if(old('value'))
                ,rating:'{{old("value")}}'
                @elseif($result !== false)
                ,rating:'{{$result->value_rate}}'
                @endif
            });

            $("#submit_review").click(function () {
                /* get rating */
                var qualityRating = quality.rateYo("rating");
                var PriceRating   = price.rateYo("rating");
                var valueRating   = value.rateYo("rating");

                $('#quality_value').val(qualityRating);
                $('#price_value').val(PriceRating);
                $('#value_value').val(valueRating);
                $('#make_new_rate').submit();
            });

        });
    </script>
@endsection
