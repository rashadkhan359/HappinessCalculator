@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Activity</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Activity</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><a href="{{ route('activity.create') }}"><button type="button"
                                            class="btn btn-block bg-gradient-primary">Add Activity</button></a></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Category</th>
                                            <th>Icon</th>
                                            <th>Name</th>
                                            <th>Color</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($activities) == 0)
                                            <tr>
                                                <td colspan="6" style="color:red;">No Activity Found !!</td>
                                            </tr>
                                        @else
                                            @foreach ($activities as $activity)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $activity->category->name }}</td>
                                                    <td>
                                                        <img src="{{ asset('/storage/' . $activity->icon->path) }}"
                                                            width="100" height="100">
                                                    </td>
                                                    <td>{{ $activity->name }}</td>
                                                    <td>#{{ $activity->color_code }}</td>
                                                    <td>
                                                        <div class="row" style="width: fit-content">
                                                            <div class="mx-3">
                                                                <a href="{{ route('activity.edit', ['activity' => $activity]) }}"
                                                                    class="btn btn-sm btn-info"><i
                                                                        class="fas fa-edit"></i></a>
                                                            </div>
                                                                 <form action="{{ route('activity.destroy', ['activity' => $activity]) }}" method="POST" class="mx-3">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button class="btn btn-sm btn-danger"><a><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                            </form>
                                                            
                                                           
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
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
