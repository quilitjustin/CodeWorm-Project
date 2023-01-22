@extends('layouts.user')

@section('content')
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">
                            <h1 class="h2">Get started</h1>
                            <p class="lead">
                                Start your journey for a new Procrastirnator!.
                            </p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <form method="POST" action="{{ route('users.store') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">First Name</label>
                                            <input class="form-control form-control-lg" type="text" name="f-name" placeholder="Enter your first name" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Middle Name</label>
                                            <input class="form-control form-control-lg" type="text" name="m-name" placeholder="Enter your middle name" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Last Name</label>
                                            <input class="form-control form-control-lg" type="text" name="l-name" placeholder="Enter your last name" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input class="form-control form-control-lg" type="password" name="password" placeholder="Enter password" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Confirm Password</label>
                                            <input class="form-control form-control-lg" type="password" name="password_confirmation" placeholder="Enter re-password" />
                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary">Create</button>
                                            <!-- <button type="submit" class="btn btn-lg btn-primary">Sign up</button> -->
                                        </div>
                                    </form>
                                    @if($errors->any())
										<ul>
											@foreach($errors->all() as $error)
												<li class="text-danger">{{ $error }}</li>
											@endforeach
										</ul>
									@endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection