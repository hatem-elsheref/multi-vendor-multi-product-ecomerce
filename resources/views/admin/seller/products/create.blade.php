@extends('layouts.backend-master')
@section('bread')
    <h1>Add New  Product</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{route('product.index')}}"><i class="fa fa-product-hunt"></i> Products</a></li>
        <li class="active">Add New Product</li>
    </ol>
@endsection
@section('css_before')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{adminAssets('css/select2.min.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{adminAssets('css/bootstrap3-wysihtml5.min.css')}}">
    <!-- bootstrap file input -->

    <link rel="stylesheet" href="{{adminAssets('file_input/css/fileinput.css')}}">
    <link rel="stylesheet" href="{{adminAssets('file_input/themes/explorer-fas/theme.css')}}">
@endsection
@section('js')
    <!-- Select2 -->
    <script src="{{adminAssets('js/select2.full.min.js')}}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{adminAssets('js/bootstrap3-wysihtml5.all.min.js')}}"></script>
    <!-- bootstrap file input -->



    <script src="{{adminAssets('file_input/js/plugins/piexif.js')}}"></script>
    <script src="{{adminAssets('file_input/js/plugins/sortable.js')}}"></script>
    <script src="{{adminAssets('file_input/js/fileinput.js')}}"></script>
{{--    <script src="{{adminAssets('file_input/js/locales/fr.js')}}"></script>--}}
{{--    <script src="{{adminAssets('file_input/js/locales/es.js')}}"></script>--}}
{{--    <script src="{{adminAssets('file_input/themes/fas/theme.js')}}"  type="text/javascript"></script>--}}
    <script src="{{adminAssets('file_input/themes/fa/theme.js')}}"  type="text/javascript"></script>
{{--    <script src="{{adminAssets('file_input/themes/explorer-fas/theme.js')}}"  type="text/javascript"></script>--}}






    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
            //bootstrap WYSIHTML5 - text editor
            $('.textarea').wysihtml5({toolbar: {
                    "font-styles": true, // Font styling, e.g. h1, h2, etc.
                    "emphasis": true, // Italics, bold, etc.
                    "lists": true, // (Un)ordered lists, e.g. Bullets, Numbers.
                    "html": false, // Button which allows you to edit the generated HTML.
                    "link": false, // Button to insert a link.
                    "image": false, // Button to insert an image.
                    "color": false, // Button to change color of font
                    "blockquote": true, // Blockquote
            }});
        });
        $(document).ready(function (){
            $('#classifier').on('change',function (){
                if ($(this).val() === 'un_known'){
                    let options=$('#main_size');
                    options.html('');
                }else{
                    $.ajax({
                        url:"{{route('product.classify')}}",
                        type: 'GET',  // http method
                        dataType: 'json', // type of response data,
                        data: { class:$(this).val()  },  // data to submit
                        success: function (data, status, xhr) {
                            let options=$('#main_size');
                            options.html('');
                            let defaultOption=document.createElement('option');
                            defaultOption.innerText='un_known';
                            defaultOption.setAttribute('selected',true)
                            // options.append(defaultOption);
                            for (item of data) {
                                let option=document.createElement('option');
                                option.innerText=item;
                                console.log(option)
                                options.append(option)
                            }

                        },
                        error: function (jqXhr, textStatus, errorMessage) {
                            // $('p').append('Error' + errorMessage);
                            // console.log(textStatus+errorMessage)
                        }
                    });
                }

            });
        });
        $("#images").fileinput({
            theme: 'fas',
            showUpload: false,
            showCaption: false,
            showRemove: true,
            showCancelButton: true,
            showCancel:true,
            browseClass: "btn btn-warning btn-sm",
            removeClass: "btn btn-danger btn-sm",
            allowedFileTypes: ['image'],
            overwriteInitial: false,
            initialPreviewAsData: true,



        });
    </script>
@endsection

@section('content')
    <section >
        <div class="row">
            <!-- Form column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add New Product</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{route('product.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                  <div class="row">
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <label for="name">Name</label>
                                              <input  type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder=" Enter The Plan Name" value="{{old('name')}}" >
                                              @error('name')
                                              <div class="invalid-feedback text-danger">{{$message}}</div>
                                              @enderror
                                          </div>
                                      </div>
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <label for="model">Model</label>
                                              <input  type="text" class="form-control @error('model') is-invalid @enderror" name="model" placeholder=" Enter The Model" value="{{old('model')}}" >
                                              @error('model')
                                              <div class="invalid-feedback text-danger">{{$message}}</div>
                                              @enderror
                                          </div>
                                      </div>
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <label for="price">Price</label>
                                              <input type="number" min="0"  class="form-control   @error('price') is-invalid @enderror " name="price" placeholder=" Enter The Plan Price" value="{{old('price')}}">
                                              @error('price')
                                              <div class="invalid-feedback text-danger">{{$message}}</div>
                                              @enderror
                                          </div>
                                      </div>
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <label for="qty">Quantity</label>
                                              <input type="number" min="0" step="1" class="form-control   @error('qty') is-invalid @enderror " name="qty" placeholder=" Enter The Quantity" value="{{old('qty')}}">
                                              @error('qty')
                                              <div class="invalid-feedback text-danger">{{$message}}</div>
                                              @enderror
                                          </div>
                                      </div>
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <label for="category">Category</label>
                                              <select name="category_id" class="form-control custom-select" required>
                                                  <option disabled selected>__select the category__</option>
                                                  @foreach($categories as $category)
                                                      <option value="{{$category->id}}" {{(old('category_id') == $category->id)?'selected':''}}>{{$category->name}}</option>
                                                  @endforeach
                                              </select>
                                              @error('category_id')
                                              <div class="invalid-feedback text-danger">{{$message}}</div>
                                              @enderror
                                          </div>
                                      </div>
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <label>Colors</label>
                                              <select class="form-control select2" multiple="" name="colors[]" style="width: 100%;"  aria-hidden="true">
                                                  <option disabled >__select the available colors</option>
                                                  @foreach($colors as $colorName => $colorHex)
                                                      <option value="{{$colorName}}" {{(in_array($colorName,(array) old('colors')))?'selected':''}}>{{$colorName}}</option>
                                                  @endforeach
                                              </select>
                                              @error('color')
                                              <div class="invalid-feedback text-danger">{{$message}}</div>
                                              @enderror
                                          </div>
                                      </div>

                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <label for="class">Classification</label>
                                              <select name="class" class="form-control custom-select" id="classifier" required>
                                                  <option selected>un_known</option>
                                                  @foreach($classes as $class)
                                                      <option value="{{$class}}" {{(old('class') == $class)?'selected':''}}>{{$class}}</option>
                                                  @endforeach
                                              </select>
                                              @error('class')
                                              <div class="invalid-feedback text-danger">{{$message}}</div>
                                              @enderror
                                          </div>
                                      </div>
                                      <div class="col-sm-12">
                                          <div class="form-group">
                                              <label>Available Sizes</label>
                                              <select class="form-control select2" id="main_size" multiple="" name="sizes[]" style="width: 100%;"  aria-hidden="true">
                                                  @if(!empty((array)old('sizes')))
                                                  @foreach((array) old('sizes') as $size)
                                                      <option selected>{{$size}}</option>
                                                      @endforeach
                                                  @else
                                                      <option selected>un_known</option>
                                                  @endif
                                              </select>
                                              @error('sizes')
                                              <div class="invalid-feedback text-danger">{{$message}}</div>
                                              @enderror
                                          </div>
                                      </div>

                                  </div>
                              </div>
                                <div class="col-sm-6">
                                    <label>Description</label>
                                    @error('description')
                                    <div class="invalid-feedback text-danger">{{$message}}</div>
                                    @enderror
                                    <textarea class="textarea" name="description" placeholder="Place some text here"
                                              style="width: 100%; height: 510px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                                {!! old('description') !!}
                                            </textarea>

                                </div>
                                <div class="col-sm-12">
                                    <label>Images</label>
                                    @error('images')
                                    <div class="invalid-feedback text-danger">{{$message}}</div>
                                    @enderror
                                <div class="form-group">
                                    <div class="file-loading">
                                        <input type="file" style="height: 100px" name="images[]" multiple  id="images"  class="file" >
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Save</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (Form) -->
        </div>   <!-- /.row -->
    </section>
@endsection
