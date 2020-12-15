@extends('layouts.backend-master')
@section('bread')
    <h1>Edit  Category</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{route('category.index')}}"><i class="fa fa-cubes"></i> Category</a></li>
        <li class="active">Edit  Category</li>
    </ol>
@endsection
@section('content')
    <section >
        <div class="row">
            <!-- Form column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit  Category</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{route('category.update',$category->id)}}">
                        @csrf
                        @method('PUT')
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input  type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder=" Enter The Category Name" value="{{$category->name}}" >
                                @error('name')
                                <div class="invalid-feedback text-danger">{{$message}}</div>
                                @enderror
                            </div>

                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Update</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (Form) -->
        </div>   <!-- /.row -->
    </section>
@endsection
