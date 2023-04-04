@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Static Content</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">View Static Content</li>
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
                            <div class="col-sm">
                            <a href="{{ route('static_content.edit', ['static_content' => $static_content]) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            </div>
                        </div>
                        </div>
                        <div class="card-body">
                        <br>
                        <div align="center">
                            <h1>{{ $static_content->title }}</h1>
                        </div>
                        <br>
                        <div class="row">
                            <center>
                                <h5>{{ $static_content->content }}</h5>
                            </center>
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