@extends('layouts.backend-master')
@section('bread')
    <h1>All Plans</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">plans</li>
    </ol>
    @endsection
@section('content')
    <section>
        <div class="row">

            <div class="col-xs-12">
                <a href="{{route('plans.create')}}" class="btn  btn-primary d-block" style="margin-bottom: 5px"><span class="fa fa-plus"></span> Add New Plan </a>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Plans <span class="badge badge-success">{{$plans->count()}}</span></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>ID</th>
                                <th>Plan Name</th>
                                <th>Plan Period</th>
                                <th>Plan Price</th>

                                <th>Number Of Sellers Progress</th>
                                <th>Label</th>
                                <th>Number Of Sellers</th>
                                <th>Actions</th>
                            </tr>
                         @foreach($plans as $plan)
                             <tr>
                                 <td>{{$plan->id}}</td>
                                 <td>{{$plan->name}}</td>
                                 <td>{{$plan->period}}</td>
                                 <td>{{$plan->price}}</td>
                                 <td>
                                     <div class="progress progress-xs">
                                         @if($users>0)
                                         <div class="progress-bar progress-bar-danger" style="width: {{(($plan->users->count()/$users)??0)*100 }}%"></div>
                                         @else
                                         <div class="progress-bar progress-bar-danger" style="width: 0%"></div>
                                        @endif
                                     </div>
                                 </td>
                                 <td>

                                     @if($users>0)
                                         <span class="badge bg-red">{{(($plan->users->count()/$users)??0)*100 }}%</span>
                                     @else
                                         <span class="badge bg-red">0%</span>
                                     @endif
                                 </td>
                                 <td>{{$plan->users->count()}}</td>
                                 <td>
                                     <button class="btn btn-sm btn-danger" onclick="RemoveItem('item-{{$plan->id}}')"> <i class="fa fa-trash"></i>   Remove </button>
                                     <a href="{{route('plans.edit',$plan->id)}}" class="btn btn-sm btn-success"><i class="fa fa-edit"></i>  Edit </a>
                                 </td>
                                 <form action="{{route('plans.destroy',$plan->id)}}" id="item-{{$plan->id}}" method="POST">
                                     @csrf
                                     @method('DELETE')
                                 </form>
                             </tr>
                         @endforeach
                            </tbody></table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection
