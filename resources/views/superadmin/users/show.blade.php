@extends('layouts.user')

@section('content')
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">
                            <h1 class="h2">View User</h1>
                            <p class="lead">
                                See their information.
                            </p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label>First Name</label>
                                            <p>{{ $user['f_name'] }}</p>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label>Middle Name</label>
                                            <p>{{ $user['m_name'] }}</p>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label>Last Name</label>
                                            <p>{{ $user['l_name'] }}</p>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label>Email</label>
                                            <p>{{ $user['email'] }}</p>
                                        </div>
                                    </div>
                                    <div class="text-center mt-3">
                                        <a href="{{ route('users.edit', $user['id']) }}" class="btn btn-lg btn-primary">Update</a>
                                        <form class="d-inline" action="{{ route('users.destroy', $user['id']) }}" method="POST"
                                        onsubmit="return confirm('You are about to delete User ID: {{ $user['id'] }}s record. \n Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-lg btn-danger">Delete</button>
                                        </form>
                                        <!-- <button type="submit" class="btn btn-lg btn-primary">Sign up</button> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection