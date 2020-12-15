

<!-- Footer Area -->
<footer id="wn__footer" class="footer__area bg__cat--8 brown--color">
    <div class="footer-static-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__widget footer__menu">
                        <div class="ft__logo">
                            <a href="{{route('website')}}">
                                <img src="{{frontAssets('images/logo/'.config('general.logo'))}}" width="150px" height="150px" alt="logo">
                            </a>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered duskam alteration variations of passages</p>
                        </div>
                        <div class="footer__content">
                            <ul class="social__net social__net--2 d-flex justify-content-center">
                                <li><a href="{{config('general.social_links.facebook')}}"><i class="bi bi-facebook"></i></a></li>
                                <li><a href="{{config('general.social_links.googlePlus')}}"><i class="bi bi-google"></i></a></li>
                                <li><a href="{{config('general.social_links.twitter')}}"><i class="bi bi-twitter"></i></a></li>
                                <li><a href="{{config('general.social_links.linkedIn')}}"><i class="bi bi-linkedin"></i></a></li>
                            </ul>
                            <ul class="mainmenu d-flex justify-content-center">
                                <li><a href="{{route('website')}}">Home</a></li>
                                <li><a href="{{route('website')}}#best_seller">Best Seller</a></li>
                                <li><a href="{{route('shop')}}">Shop</a></li>
                                <li><a href="{{route('about')}}">About</a></li>
                                <li><a href="{{route('contact')}}">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright__wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="copyright">
                        <div class="copy__right__inner text-left">
                            <p>Copyright <i class="fa fa-copyright"></i> <a href="https://www.linkedin.com/in/hatem-mohamed-31b8901a2/">Hatem Mohamed Elsheref.</a> All Rights Reserved</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="payment text-right">
                        <img src="{{frontAssets('images/icons/payment.png')}}" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- //Footer Area -->

</div>
<!-- //Main wrapper -->

<!-- JS Files -->
<script src="{{frontAssets('js/vendor/jquery-3.2.1.min.js')}}"></script>
<script src="{{frontAssets('js/popper.min.js')}}"></script>
<script src="{{frontAssets('js/bootstrap.min.js')}}"></script>
<script src="{{frontAssets('js/plugins.js')}}"></script>
<script src="{{frontAssets('js/active.js')}}"></script>
<script src="{{adminAssets('js/swal.js')}}"></script>
<script>

    function sureTheTransaction(){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, confirm it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var temporary_key='{{uniqid()}}';
                var token='{{csrf_token()}}';
                $.ajax({
                    url:'{{route('checkout.confirm')}}',
                    method:'POST',
                    dataType: 'json', // type of response data,
                    data:{'tmp_key':temporary_key,'_token':token},
                    success:function (response){
                        $('#temporary_key').val(temporary_key)
                        if(response.status){
                            $('#completeTheTransaction').submit();
                        }else{
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Try Again ..',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }
                });
            }
        })
    }



</script>

@yield('js')
</body>
</html>
