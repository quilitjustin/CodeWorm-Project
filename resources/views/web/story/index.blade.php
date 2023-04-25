@extends('layouts.web.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Table of Contents</h1>
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
                                <h3 class="card-title">List of Current Chapters</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table>
                                    <thead>
                                        <tr>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($stories as $story)
                                            <tr>
                                                <td class="text-left">
                                                    <a href="{{ route('web.stories.show', $story->encrypted_id) }}">
                                                        Chapeter{{ $loop->index + 1 . ': ' . $story->title }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                        No Story Available
                                        @endforelse
                                    </tbody>
                                    <tfoot>

                                    </tfoot>
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
        <!-- /.content -->
    </div>
@endsection

@section('script')
@endsection
