@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inquiries</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('super.inquiries.index') }}">Inquiries</a></li>
                        <li class="breadcrumb-item active">Show</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @include('superadmin.inquiries.left_side')

                <div class="col-md-9">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Read Inquiry</h3>

                            <div class="card-tools">
                                <a href="#" class="btn btn-tool" title="Previous"><i
                                        class="fas fa-chevron-left"></i></a>
                                <a href="#" class="btn btn-tool" title="Next"><i
                                        class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="mailbox-read-info">
                                <h5>From: {{ $inquiries->name }}
                                    <span
                                        class="mailbox-read-time float-right">{{ \Carbon\Carbon::parse($inquiries->created_at)->diffForHumans() }}</span>
                                </h5>
                                <p>
                                    Email: {{ $inquiries->email }}
                                    <br>
                                    Phone: {{ $inquiries->phone }}
                                </p>
                            </div>
                            <!-- /.mailbox-read-info -->
                            <div class="mailbox-controls with-border text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm" data-container="body"
                                        title="Delete">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm" data-container="body"
                                        title="Reply">
                                        <i class="fas fa-reply"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm" data-container="body"
                                        title="Forward">
                                        <i class="fas fa-share"></i>
                                    </button>
                                </div>
                                <!-- /.btn-group -->
                                <button type="button" class="btn btn-default btn-sm" title="Print">
                                    <i class="fas fa-print"></i>
                                </button>
                            </div>
                            <!-- /.mailbox-controls -->
                            <div class="mailbox-read-message">
                                {{ $inquiries->message }}
                            </div>
                            <!-- /.mailbox-read-message -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer bg-white">
                            {{-- <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                                <li>
                                    <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>

                                    <div class="mailbox-attachment-info">
                                        <a href="#" class="mailbox-attachment-name"><i
                                                class="fas fa-paperclip"></i> Sep2014-report.pdf</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                                            <span>1,245 KB</span>
                                            <a href="#" class="btn btn-default btn-sm float-right"><i
                                                    class="fas fa-cloud-download-alt"></i></a>
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <span class="mailbox-attachment-icon"><i class="far fa-file-word"></i></span>

                                    <div class="mailbox-attachment-info">
                                        <a href="#" class="mailbox-attachment-name"><i
                                                class="fas fa-paperclip"></i> App Description.docx</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                                            <span>1,245 KB</span>
                                            <a href="#" class="btn btn-default btn-sm float-right"><i
                                                    class="fas fa-cloud-download-alt"></i></a>
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo1.png"
                                            alt="Attachment"></span>

                                    <div class="mailbox-attachment-info">
                                        <a href="#" class="mailbox-attachment-name"><i class="fas fa-camera"></i>
                                            photo1.png</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                                            <span>2.67 MB</span>
                                            <a href="#" class="btn btn-default btn-sm float-right"><i
                                                    class="fas fa-cloud-download-alt"></i></a>
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo2.png"
                                            alt="Attachment"></span>

                                    <div class="mailbox-attachment-info">
                                        <a href="#" class="mailbox-attachment-name"><i class="fas fa-camera"></i>
                                            photo2.png</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                                            <span>1.9 MB</span>
                                            <a href="#" class="btn btn-default btn-sm float-right"><i
                                                    class="fas fa-cloud-download-alt"></i></a>
                                        </span>
                                    </div>
                                </li>
                            </ul> --}}
                        </div>
                        <!-- /.card-footer -->
                        <div class="card-footer">
                            {{-- <div class="float-right">
                                <button type="button" class="btn btn-default"><i class="fas fa-reply"></i>
                                    Reply</button>
                                <button type="button" class="btn btn-default"><i class="fas fa-share"></i>
                                    Forward</button>
                            </div> --}}
                            <button type="button" class="btn btn-default"><i class="far fa-trash-alt"></i>
                                Delete</button>
                            <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    @include('layouts.superadmin.inc_delete')
@endsection
