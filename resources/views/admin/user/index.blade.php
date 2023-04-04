@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">User</li>
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
                                <h3 class="card-title"><a href="{{ route('user.create') }}"><button type="button"
                                            class="btn btn-block bg-gradient-primary">Add User</button></a></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($users) == 0)
                                            <tr>
                                                <td colspan="5" style="color:red;">No User Found !!</td>
                                            </tr>
                                        @else
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    @if ($user->status == 1)
                                                        <td><button class="btn btn-sm btn-success">Active</button></td>
                                                    @else
                                                        <td><button class="btn btn-sm btn-danger">In-Active</button></td>
                                                    @endif
                                                    <td>
                                                        <div class="row" style="width: fit-content">
                                                            <div class="mx-3">
                                                                <a href="{{ route('user.show', ['user' => $user]) }}"
                                                                    class="btn btn-sm btn-warning"><i
                                                                        class="fas fa-eye"></i></a>
                                                            </div>
                                                            <div class="mx-3">
                                                                <a href="{{ route('user.edit', ['user' => $user]) }}"
                                                                    class="btn btn-sm btn-info"><i
                                                                        class="fas fa-edit"></i></a>
                                                            </div>
                                                            <div class="mx-3">
                                                                <a href="{{ route('user.destroy', ['user' => $user]) }}"
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
