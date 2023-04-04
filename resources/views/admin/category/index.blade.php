@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Category</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Category</li>
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
                                <h3 class="card-title"><a href="{{ route('category.create') }}"><button type="button"
                                            class="btn btn-block bg-gradient-primary">Add Category</button></a></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($categories) == 0)
                                            <tr>
                                                <td colspan="3" style="color:red;">No Category Found !!</td>
                                            </tr>
                                        @else
                                            @foreach ($categories as $category)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $category->name }}</td>
                                                    <td>
                                                        <div class="row" style="width: fit-content">
                                                            <div class="mx-3">
                                                                <a href="{{ route('category.show', ['category' => $category]) }}"
                                                                    class="btn btn-sm btn-warning"><i
                                                                        class="fas fa-eye"></i></a>
                                                            </div>
                                                            <div class="mx-3">
                                                                <a href="{{ route('category.edit', ['category' => $category]) }}"
                                                                    class="btn btn-sm btn-info"><i
                                                                        class="fas fa-edit"></i></a>
                                                            </div>
                                                            <div class="mx-3">
                                                                <a href="{{ route('category.destroy', ['category' => $category]) }}"
                                                                    class="btn btn-sm btn-danger"><i
                                                                        class="fas fa-trash"></i></a>
                                                            </div>
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