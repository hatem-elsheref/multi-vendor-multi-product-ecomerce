@extends('layouts.backend-master')
@section('bread')
    <h1>Add New  Category</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{route('category.index')}}"><i class="fa fa-cubes"></i> Category</a></li>
        <li class="active">Add New Category</li>
    </ol>
@endsection
@section('content')
    <section >
        <div class="row">
            <!-- Form column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add New Category</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{route('category.store')}}">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input  type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder=" Enter The Category Name" value="{{old('name')}}" >
                                @error('name')
                                <div class="invalid-feedback text-danger">{{$message}}</div>
                                @enderror
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
