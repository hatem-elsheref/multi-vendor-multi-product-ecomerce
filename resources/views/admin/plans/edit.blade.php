@extends('layouts.backend-master')
@section('bread')
    <h1>Edit  Plan</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{route('plans.index')}}"><i class="fa fa-money"></i> Plans</a></li>
        <li class="active">Edit Plan</li>
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
                        <h3 class="box-title">Edit Plan</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{route('plans.update',$plan->id)}}">
                        @csrf
                        @method('PUT')
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input  type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder=" Enter The Plan Name" value="{{$plan->name}}" >
                                @error('name')
                                <div class="invalid-feedback text-danger">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Period</label>
                                <select name="period" class="form-control custom-select" required>
                                    <option disabled selected>__select the period (number of months)</option>
                                    @foreach(range(1,12) as $month)
                                        <option value="{{$month}}" {{($plan->period == $month)?'selected':''}}>{{$month}}</option>
                                    @endforeach
                                </select>
                                @error('period')
                                <div class="invalid-feedback text-danger">{{$message}}</div>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" min="0" step="0.1" class="form-control   @error('price') is-invalid @enderror " name="price" placeholder=" Enter The Plan Price" value="{{$plan->price}}">
                                @error('price')
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
