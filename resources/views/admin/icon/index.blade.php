@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Icon</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Icon</li>
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
                                <h3 class="card-title"><a href="{{ route('icon.create') }}"><button type="button"
                                            class="btn btn-block bg-gradient-primary">Add Icon</button></a></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Icon</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($icons) == 0)
                                            <tr>
                                                <td colspan="3" style="color:red;">No Icons Found !!</td>
                                            </tr>
                                        @else
                                            @foreach ($icons as $icon)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <img src= "{{ asset('/storage/'.($icon->file_name)) }}" width="100" height="100">
                                                        </td>
                                                    <td>{{ $icon->name }}</td>
                                                    <td>
                                                        <div class="row" style="width: fit-content">
                                                            {{-- <div class="mx-3">
                                                                <a href="{{ route('icon.show', ['icon' => $icon]) }}"
                                                                    class="btn btn-sm btn-warning"><i
                                                                        class="fas fa-eye"></i></a>
                                                            </div>
                                                            <div class="mx-3">
                                                                <a href="{{ route('icon.edit', ['icon' => $icon]) }}"
                                                                    class="btn btn-sm btn-info"><i
                                                                        class="fas fa-edit"></i></a>
                                                            </div> --}}

                                                            <form action="{{ route('icon.destroy', ['icon' => $icon]) }}" method="POST" class="mx-3">
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