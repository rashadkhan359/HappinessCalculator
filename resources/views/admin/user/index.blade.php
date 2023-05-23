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
                            {{-- <div class="card-header">
                                <h3 class="card-title"><a href="{{ route('user.create') }}"><button type="button"
                                            class="btn btn-block bg-gradient-primary">Add User</button></a></h3>
                            </div> --}}
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
                                                    <td>
                                                        @if ($user->status == 1)
                                                            <a id="status{{ $user->id }}"
                                                                class="btn btn-success py-2 px-2">Active</a>
                                                        @else
                                                            <a id="status{{ $user->id }}"
                                                                class="btn btn-danger py-2 px-2">In-Active</a>
                                                        @endif
                                                    </td>
                                                    <script>
                                                        $(document).ready(function() {
                                                            $("#status{{ $user->id }}").click(function() {
                                                                var id = {{ $user->id }}
                                                                $.ajax({
                                                                    url: '{{ route('change_status') }}',
                                                                    method: 'POST',
                                                                    data: {
                                                                        'id': id,
                                                                        '_token': "{{ csrf_token() }}"
                                                                    },
                                                                    success: function(data) {
                                                                        console.log(data)
                                                                        if (data == 0) {
                                                                            $("#status{{ $user->id }}").text('In-Active');
                                                                            $("#status{{ $user->id }}").css({
                                                                                'background-color': '#dc3545',
                                                                                'border': 'none'
                                                                            });
                                                                        } else {
                                                                            $("#status{{ $user->id }}").text('Active');
                                                                            $("#status{{ $user->id }}").css({
                                                                                'background-color': '#28a745',
                                                                                'border': 'none'
                                                                            });
                                                                        }
                                                                    }
                                                                });
                                                            });
                                                        });
                                                    </script>

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
                                                            <form action="{{ route('user.destroy', ['user' => $user]) }}"
                                                                method="POST" class="mx-3">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button class="btn btn-sm btn-danger"><a><i
                                                                            class="fa fa-trash" aria-hidden="true"></i></a>
                                                            </form>


                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                {{-- <div class="d-flex justify-content-center">
                                    {!! $users->links() !!}
                                </div> --}}
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
    <script>
        $(document).ready(function() {
            $('#change_status').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/',
                    type: 'POST',
                    success: function(data) {
                        console.log(data); // log the response to the console
                        // do something with the response data here
                    },
                    error: function(data) {
                        console.log(data); // log any errors to the console
                    }
                });
            });
        });
    </script>
@endsection
