    @extends('admin.layouts.app')
    @section('content')
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Contact Details</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Contact Details</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <h3 class="card-title">Contact Details</h3>
                                        </div>
                                        <div class="col-xs">
                                            <a href="{{route('contactdetails.edit',['contactdetail'=>$details]) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        </div>
                                        {{-- <div class="col-xs">
                                            <a href="{{route('contactdetails.edit', ['details' => $details]) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        </div> --}}
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4><b>Email</b> :
                                                @if (!empty($details->contact_email))
                                                    {{ $details->contact_email }}
                                                @else
                                                    <span>Not Found</span>
                                                @endif
                                            </h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4><b>Phone</b> : @if (!empty($details->contact_phone))
                                                    {{ $details->contact_phone }}
                                                @else
                                                    <span>Not Found</span>
                                                @endif
                                            </h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4><b>Instagram url</b> : @if (!empty($details->instagram_url))
                                                    {{ $details->instagram_url }}
                                                @else
                                                    <span>Not Found</span>
                                                @endif
                                            </h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4><b>Facebook url</b> : @if (!empty($details->facebook_url))
                                                    {{ $details->facebook_url }}
                                                @else
                                                    <span>Not Found</span>
                                                @endif
                                            </h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4><b>Twitter url</b> : @if (!empty($details->twitter_url))
                                                    {{ $details->twitter_url }}
                                                @else
                                                    <span>Not Found</span>
                                                @endif
                                            </h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4><b>Linkdin url</b> : @if (!empty($details->linkdin_url))
                                                    {{ $details->linkdin_url }}
                                                @else
                                                    <span>Not Found</span>
                                                @endif
                                        </div>
                                        <div class="col-md-6">
                                            <h4><b>Youtube url</b> : @if (!empty($details->youtube_url))
                                                    {{ $details->youtube_url }}
                                                @else
                                                    <span>Not Found</span>
                                                @endif
                                            </h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4><b>Website url</b> : @if (!empty($details->website_url))
                                                    {{ $details->website_url }}
                                                @else
                                                    <span>Not Found</span>
                                                @endif
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>

                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
        </div>
    @endsection
