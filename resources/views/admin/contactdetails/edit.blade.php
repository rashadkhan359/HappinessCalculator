@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Contact Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Edit Contact Details</li>
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
                                <h3 class="card-title">Edit Contact Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{route('contactdetails.update',['contactdetail' => $details])}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="card-body row">
                                    <div class="form-group col-6">
                                        <label for="email">Email</label>
                                        <input type="email" id="contact_email" name="contact_email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ $details->contact_email }}" placeholder="Email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="phone">Phone</label>
                                        <input type="text" id="phone" name="contact_phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ $details->contact_phone }}" placeholder="Phone">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="instagram_url">Instagram Url</label>
                                        <input type="text" id="instagram_url" name="instagram_url"
                                            class="form-control @error('instagram_url') is-invalid @enderror"
                                            value="{{ $details->instagram_url }}" placeholder="Instagram url">
                                        @error('instagram_url')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="facebook_url">Facebook Url</label>
                                        <input type="text" id="facebook_url" name="facebook_url"
                                            class="form-control @error('facebook_url') is-invalid @enderror"
                                            value="{{ $details->facebook_url }}" placeholder="Facebook url">
                                        @error('facebook_url')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="twitter_url">Twitter Url</label>
                                        <input type="text" id="twitter_url" name="twitter_url"
                                            class="form-control @error('twitter_url') is-invalid @enderror"
                                            value="{{ $details->twitter_url }}" placeholder="Twitter url">
                                        @error('twitter_url')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="linkdin_url">Linkdin Url</label>
                                        <input type="text" id="linkdin_url" name="linkdin_url"
                                            class="form-control @error('linkdin_url') is-invalid @enderror"
                                            value="{{ $details->linkdin_url }}" placeholder="Linkdin url">
                                        @error('linkdin_url')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="youtube_url">Youtube Url</label>
                                        <input type="text" id="youtube_url" name="youtube_url"
                                            class="form-control @error('youtube_url') is-invalid @enderror"
                                            value="{{ $details->youtube_url }}" placeholder="Youtube url">
                                        @error('youtube_url')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="website_url">Website Url</label>
                                        <input type="text" id="website_url" name="website_url"
                                            class="form-control @error('website_url') is-invalid @enderror"
                                            value="{{ $details->website_url }}" placeholder="Youtube url">
                                        @error('website_url')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                        <!-- right column -->
                        <div class="col-md-6">

                        </div>
                        <!--/.col (right) -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
