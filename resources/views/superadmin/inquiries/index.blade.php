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
                        <li class="breadcrumb-item active">Index</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('superadmin.inquiries.left_side')
            <div class="col-md-9">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Inbox</h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="Search Mail">
                                <div class="input-group-append">
                                    <div class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="mailbox-controls">
                            <!-- Check all button -->
                            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i
                                    class="far fa-square"></i>
                            </button>
                            <!--<div class="btn-group">-->
                            <!--    <button type="button" class="btn btn-default btn-sm">-->
                            <!--        <i class="far fa-trash-alt"></i>-->
                            <!--    </button>-->
                            <!--    <button type="button" class="btn btn-default btn-sm">-->
                            <!--        <i class="fas fa-reply"></i>-->
                            <!--    </button>-->
                            <!--    <button type="button" class="btn btn-default btn-sm">-->
                            <!--        <i class="fas fa-share"></i>-->
                            <!--    </button>-->
                            <!--</div>-->
                            <!-- /.btn-group -->
                            <button type="button" class="btn btn-default btn-sm">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <div class="float-right">
                                1-50/200
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                                <!-- /.btn-group -->
                            </div>
                            <!-- /.float-right -->
                        </div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped">
                                <tbody>
                                    @forelse($inquiries as $inquiry)
                                        <tr>
                                            <td>
                                                <div class="icheck-primary">
                                                    <input type="checkbox" value="" id="check2">
                                                    <label for="check2"></label>
                                                </div>
                                            </td>
                                            <td class="mailbox-star"><a href="#"><i
                                                        class="fas fa-star-o text-warning"></i></a></td>
                                            <td class="mailbox-name"><a href="{{ route('super.inquiries.show', $inquiry->encrypted_id) }}">{{ $inquiry->name }}</a>
                                            </td>
                                            <td class="mailbox-name"><b>Subject:</b> Inquiry
                                            </td>
                                            <td class="mailbox-subject"><b></b>
                                                <span class="badge {{ $inquiry->status == 'pending' ? 'bg-danger' : 'bg-success' }}">{{ $inquiry->status }}</span>
                                            </td>
                                            {{-- <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td> --}}
                                            <td class="mailbox-date">
                                                <p>{{ \Carbon\Carbon::parse($inquiry->created_at)->diffForHumans() }}</p>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                            <!-- /.table -->
                        </div>
                        <!-- /.mail-box-messages -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer p-0">
                        <div class="mailbox-controls">
                            <!-- Check all button -->
                            <button type="button" class="btn btn-default btn-sm checkbox-toggle">
                                <i class="far fa-square"></i>
                            </button>
                            <!--<div class="btn-group">-->
                            <!--    <button type="button" class="btn btn-default btn-sm">-->
                            <!--        <i class="far fa-trash-alt"></i>-->
                            <!--    </button>-->
                            <!--    <button type="button" class="btn btn-default btn-sm">-->
                            <!--        <i class="fas fa-reply"></i>-->
                            <!--    </button>-->
                            <!--    <button type="button" class="btn btn-default btn-sm">-->
                            <!--        <i class="fas fa-share"></i>-->
                            <!--    </button>-->
                            <!--</div>-->
                            <!-- /.btn-group -->
                            <button type="button" class="btn btn-default btn-sm">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <div class="float-right">
                                1-50/200
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                                <!-- /.btn-group -->
                            </div>
                            <!-- /.float-right -->
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script>
        $(function() {
            //Enable check and uncheck all functionality
            $('.checkbox-toggle').click(function() {
                var clicks = $(this).data('clicks')
                if (clicks) {
                    //Uncheck all checkboxes
                    $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
                    $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass(
                        'fa-square')
                } else {
                    //Check all checkboxes
                    $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
                    $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass(
                        'fa-check-square')
                }
                $(this).data('clicks', !clicks)
            })

            //Handle starring for font awesome
            $('.mailbox-star').click(function(e) {
                e.preventDefault()
                //detect type
                var $this = $(this).find('a > i')
                var fa = $this.hasClass('fa')

                //Switch states
                if (fa) {
                    $this.toggleClass('fa-star')
                    $this.toggleClass('fa-star-o')
                }
            })
        })
    </script>
@endsection
