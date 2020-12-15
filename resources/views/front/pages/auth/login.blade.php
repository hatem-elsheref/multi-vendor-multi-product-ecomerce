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
                            <span class="breadcrumb_item active">Login</span>
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
                <div class="col-lg-12 col-12">
                    <div class="my__account__wrapper">
                        <h3 class="account__title">Login</h3>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="account__form">
                                <div class="input__box">
                                    <label for="email">email address <span>*</span></label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="text-danger" style="font-size: small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="input__box">
                                    <label for="password">Password<span>*</span></label>
                                    <input id="password" type="password" name="password" required autocomplete="current-password">
                                    @error('password')
                                    <span class="text-danger" style="font-size: small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form__btn">
                                    <button type="submit">Login</button>
                                    <label class="label-for-checkbox" for="rememberme">
                                        <input id="rememberme" class="input-checkbox" name="remember" value="forever" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                        <span>Remember me</span>
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="forget_pass" href="{{ route('password.request') }}">Lost your password?</a>
                                @endif
                                <a class="forget_pass" href="{{route('register')}}">I Don't Have An Account</a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End My Account Area -->
@endsection

