@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">User Details</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    @if ($errors->any())
        <div class="card-body">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach

            </div>


        </div>
    @endif
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="row">
                            <div class="col-sm-10">
                            <h3 class="card-title">View Details</h3>
                            </div>
                            <div class="col-xs">
                            <a href="{{ route('user.edit', ['user' => $user]) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            </div>
                            <div class="col-sm">
                                <a href="{{ route('user.destroy', ['user' => $user]) }}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                        </div>
                        <div class="card-body">
                        <br>
                        <div class="row">
                            <h4><b>Name</b> : {{$user->name}}</h4>
                        </div>
                        <br>
                        <div class="row">
                            <h4><b>Email Id</b> : {{$user->email}}</h4>
                        </div>
                        <br>
                        <div class="row">
                            <h4><b>Phone Number</b> : {{$user->phone}}</h4>
                        </div>
                        <br>
                        <div class="row">
                            <h4><b>Gender</b> : {{$user->gender}}</h4>
                        </div>
                        <br>
                        <div class="row">
                            <h4><b>Date of Birth</b> : {{$user->date_of_birth}}</h4>
                        </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection