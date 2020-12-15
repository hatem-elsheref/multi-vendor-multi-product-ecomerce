@extends('layouts.frontend-master')
@section('content')
    <!-- Start Bradcaump area -->
    <div class="ht__bradcaump__area bg-image--6">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Shop </h2>
                        <nav class="bradcaump-content">
                            <a class="breadcrumb_item" href="{{route('website')}}">Home</a>
                            <span class="brd-separetor">/</span>
                                <span class="breadcrumb_item active">Products (results)</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bradcaump area -->
    <!-- Start Shop Page -->
    <div class="page-shop-sidebar left--sidebar bg--white section-padding--lg">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12 order-2 order-lg-1 md-mt-40 sm-mt-40">
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
                                        <div id="slider-range" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all" style="left: 20.4082%; width: 59.1837%;"></div><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 20.4082%;"></span><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 79.5918%;"></span></div>
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
                <div class="col-lg-9 col-12 order-1 order-lg-2">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="shop__list__wrapper d-flex flex-wrap flex-md-nowrap justify-content-between">
                                <div class="shop__list nav justify-content-center" role="tablist">
                                    <a class="nav-item nav-link active" data-toggle="tab" href="#nav-grid" role="tab"><i class="fa fa-th"></i></a>
                                    <a class="nav-item nav-link" data-toggle="tab" href="#nav-list" role="tab"><i class="fa fa-list"></i></a>
                                </div>
                                @if($products->count() > 0)
                                    <p>Showing {{(($products->perPage() * $products->currentPage()) - $products->perPage()+1)}}–{{($products->perPage() * $products->currentPage())}} of {{$products->total()}} results</p>
                                @else
                                    <p>Showing 0-0 of 0 results</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab__container">
                        <div class="shop-grid tab-pane fade show active" id="nav-grid" role="tabpanel">
                            <div class="row">
                                @forelse($products as $product)
                                    <!-- Start Single Product -->
                                    <div class="product product__style--3 col-lg-4 col-md-4 col-sm-6 col-12">
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
                                                        <li class="text-dark">{{$product->stock->stock}}</li>
                                                    </ul>
                                                    <div class="action">
                                                        <div class="actions_inner">
                                                            <ul class="add_to_links">
                                                                <li><a class="cart" href="{{route('cart.add',$product->slug)}}"><i class="bi bi-shopping-bag4"></i></a></li>
                                                                <li><a data-toggle="modal" title="Quick View" class="quickview modal-view detail-link" href="#product-modal-shop-{{$product->id}}"><i class="bi bi-search"></i></a></li>
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
                                    <!-- End Single Product -->
                                        @empty
                                          <p style="margin: auto">No Results Founded ..</p>
                                @endforelse


                            </div>
                            {!! $products->render() !!}
                        </div>
                        <div class="shop-grid tab-pane fade" id="nav-list" role="tabpanel">
                            <div class="list__view__wrapper">
                            @forelse($products as $product)
                                <!-- Start Single Product -->
                                <div class="list__view">
                                    <div class="thumb">

                                        <a class="first__img" href="{{route('product.details',$product->slug)}}"><img src="{{uploadedAssets($product->images[0]->src)}}" alt="product image {{$product->name}}"></a>
                                        <a class="second__img animation1" href="{{route('product.details',$product->slug)}}"><img src="{{uploadedAssets($product->images[1]->src)}}" alt="product image {{$product->name}}"></a>
                                    </div>
                                    <div class="content">
                                        <h2><a href="{{route('product.details',$product->slug)}}">{{$product->name}}</a></h2>
                                        <ul class="rating d-flex">
                                             @for($i=0;$i<$product->quality_rate;$i++)
                                                <li class="on"><i class="fa fa-star"></i></li>
                                            @endfor
                                            @for($i=0;$i<5-$product->quality_rate;$i++)
                                                <li><i class="fa fa-star-o"></i></li>
                                            @endfor
                                        </ul>
                                        <ul class="prize__box">
                                            <li>$ {{$product->price}}</li>
                                        </ul>
                                        <p>{!! $product->description !!}</p>
                                        <ul class="cart__action d-flex">
                                            <li class="cart"><a href="{{route('cart.add',$product->slug)}}">Add to cart</a></li>
                                        </ul>

                                    </div>
                                </div>
                                <!-- End Single Product -->
                                @empty
                                    <p style="margin: 0 auto" class="text-center">No Results Founded ..</p>

                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Shop Page -->
    <!-- QUICKVIEW PRODUCT -->
    <div id="quickview-wrapper">
    @foreach($products as $product)
        <!-- Modal -->
            <div class="modal fade" id="product-modal-shop-{{$product->id}}" tabindex="-1" role="dialog">
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
    </div>
    <!-- END QUICKVIEW PRODUCT -->
    @endsection
