@extends('layouts.user')

@section('content')
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">
                            <h1 class="h2">Profile</h1>
                            <p class="lead">
                                Update your profile
                            </p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <form method="POST" action="{{ route('profile_update', Auth::user()->id) }}">
                                        @csrf
                                        {{-- So the system would know what email it would ignore because email must be unique --}}
                                        <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                                        {{-- So the system would know what kind of update you want to make --}}
                                        <input type="text" value="details" name="action" hidden>
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">First Name</label>
                                                <input class="form-control form-control-lg" type="text" name="f-name" value="{{ Auth::user()->f_name }}" placeholder="Enter your first name" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Middle Name</label>
                                                <input class="form-control form-control-lg" type="text" name="m-name" value="{{ Auth::user()->m_name }}" placeholder="Enter your middle name" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Last Name</label>
                                                <input class="form-control form-control-lg" type="text" name="l-name" value="{{ Auth::user()->l_name }}" placeholder="Enter your last name" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Email</label>
                                                <input class="form-control form-control-lg" type="email" name="email" value="{{ Auth::user()->email }}" placeholder="Enter your email" />
                                            </div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary">Update</button>
                                            <!-- <button type="submit" class="btn btn-lg btn-primary">Sign up</button> -->
                                        </div>
                                    </form>
                                    @if($errors->any())
										<ul>
                                            {{-- Since password and password_confirmation is not a part of this form, we need to separate where the error would appear. --}}
                                            @if(!($errors->has('password') || $errors->has('password_confirmation')))
                                                @foreach($errors->all() as $error)
                                                    <li class="text-danger">{{ $error }}</li>
                                                @endforeach
                                            @endif
										</ul>
									@endif
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <form method="POST" action="{{ route('profile_update', Auth::user()->id) }}">
                                        @csrf
                                        {{-- So the system would know what email it would ignore because email must be unique --}}
                                        <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                                        {{-- So the system would know what kind of update you want to make --}}
                                        <input type="text" value="password" name="action" hidden>
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Password</label>
                                                <input class="form-control form-control-lg" type="password" name="password" placeholder="Enter password" />
                                            </div>
                                            <div class="mb-3  col-md-6">
                                                <label class="form-label">Confirm New Password</label>
                                                <input class="form-control form-control-lg" type="password" name="password_confirmation" placeholder="Enter re-password" />
                                            </div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary">Update</button>
                                            <!-- <button type="submit" class="btn btn-lg btn-primary">Sign up</button> -->
                                        </div>
                                    </form>
                                    @error('password')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    @error('password_confirmation')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection