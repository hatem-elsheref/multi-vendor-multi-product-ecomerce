@extends('layouts.frontend-master')
@section('content')
    <!-- Start Bradcaump area -->
    <div class="ht__bradcaump__area bg-image--6">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">My Account</h2>
                        <nav class="bradcaump-content">
                            <a class="breadcrumb_item" href="{{route('website')}}">Home</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb_item active">Profile</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bradcaump area -->
    <!-- Start My Account Area -->
    <section class="my_account_area pt--80 pb--55 bg--white">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="my__account__wrapper">
                        <h3 class="account__title">My Personal Information</h3>
                        <form method="POST" action="{{ route('account.information') }}" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="account__form">
                                <div class="input__box">
                                    <label for="name">Name <span>*</span></label>
                                    <input id="name" type="text" name="name" value="{{ auth()->user()->name }}" required autocomplete="name" autofocus>
                                    @error('name')
                                    <span class="text-danger" style="font-size: small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                               @if(auth()->user()->role == SELLER)
                                    <div class="input__box">
                                        <label for="stock">Stock Name <span>*</span></label>
                                        <input id="stock" type="text" name="stock" value="{{ auth()->user()->stock }}" required autocomplete="stock" autofocus>
                                        @error('stock')
                                        <span class="text-danger" style="font-size: small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                @endif
                               @if(auth()->user()->role == SELLER)
                                    <div class="input__box">
                                        <label for="plan">Plan <span>*</span></label>
                                        <input id="plan" type="text"  value="{{ auth()->user()->plan->name }}" readonly disabled>
                                    </div>
                                @endif
                                <div class="input__box">
                                    <label for="email">email address <span>*</span></label>
                                    <input id="email" type="email" name="email" value="{{ auth()->user()->email }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="text-danger" style="font-size: small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="input__box">
                                    <label for="image">Image <span>*</span></label>
                                    <input id="image" type="file" name="image">
                                    @error('image')
                                    <span class="text-danger" style="font-size: small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <img id="tmp_image" src="{{uploadedAssets(auth()->user()->image)}}" width="45px" height="45px" onclick="document.getElementById('image').click()">
                                </div>
                                <div class="form__btn">
                                    <button type="submit">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="my__account__wrapper">
                        <h3 class="account__title">My Security Information</h3>
                        <form method="POST" action="{{ route('account.password') }}">
                            @csrf
                            @method('put')
                            <div class="account__form">
                                <div class="input__box">
                                    <label for="old_password">Old Password<span>*</span></label>
                                    <input id="old_password" type="password" name="old_password" required autocomplete="current-password">
                                    @error('old_password')
                                    <span class="text-danger" style="font-size: small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="input__box">
                                    <label for="password">Password<span>*</span></label>
                                    <input id="password" type="password" name="password" required autocomplete="password">
                                    @error('password')
                                    <span class="text-danger" style="font-size: small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="input__box">
                                    <label for="password-confirm">Confirm Password<span>*</span></label>
                                    <input id="password-confirm" type="password"  name="password_confirmation" required autocomplete="new-password">
                                </div>
                                <div class="form__btn">
                                    <button type="submit">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-12">
                    <h3 class="account__title">Trace Your Orders</h3><br>
                    <h3 class="text-danger">Pending Orders</h3>
                    @foreach($my_orders_pending as $order)
                       Trace Code :  <span class="text-primary"> {{$order->trace_code}}</span>
                    @endforeach
                    <br>
                    <hr>
                    <h3 class="text-danger">Shipped Orders</h3>
                    @foreach($my_orders_shipped as $order)
                        Trace Code :  <span class="text-primary">{{$order->trace_code}}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- End My Account Area -->
@endsection

@section('js')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#tmp_image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#image").change(function() {
            readURL(this);
        });
    </script>
    @endsection
