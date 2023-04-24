@extends('layouts.web.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        {{-- <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('stories.index') }}">Story</a></li>
                    <li class="breadcrumb-item active">Index</li>
                </ol> --}}
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-navy">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3 class="card-title font-weight-bold">{{ $story->title }}</h3>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                            <label class="custom-control-label" for="customSwitch1">Dark Mode</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                {!! $story->contents !!}
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-4 text-left">
                                        @if (!is_null($previous))
                                            <a href="{{ route('web.stories.show', $previous->encrypted_id) }}"><i class="fas fa-chevron-left"></i> Previous</a>
                                        @endif
                                    </div>
                                    <div class="col-4 text-center">
                                        <a href="{{ route('web.stories.index') }}">Table of Contents</a>
                                    </div>
                                    <div class="col-4 text-right">
                                        @if (!is_null($next))
                                            <a href="{{ route('web.stories.show', $next->encrypted_id) }}">Next <i class="fas fa-chevron-right"></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#customSwitch1').change(function() {
                if ($(this).is(':checked')) {
                    // code to execute when checkbox is checked
                    $('body').addClass('dark-mode');
                } else {
                    // code to execute when checkbox is unchecked
                    $('body').removeClass('dark-mode');
                }
            });
        });
    </script>
@endsection
