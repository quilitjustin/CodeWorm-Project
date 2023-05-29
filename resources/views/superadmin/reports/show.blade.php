@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-navy font-weight-bold d-inline mr-1">Reports</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('super.reports.index') }}">Reports</a></li>
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
                <!-- /.col -->
                <div class="col-md-12">
                    <div class="card card-navy">
                        <div class="card-header">
                            <h3 class="card-title">
                                Report Details
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Reported By</label><br>
                                    <a
                                        href="{{ route('super.users.show', $report->created_by_user->encrypted_id) }}">{{ $report->created_by_user->f_name . ' ' . $report->created_by_user->l_name }}</a>
                                </div>
                                @if(!is_null($user))
                                <div class="col-md-12 mb-3">
                                    <label>Who is being reported</label><br>
                                    <a
                                        href="{{ route('super.users.show', $user->encrypted_id) }}">{{ $user->f_name . ' ' . $user->l_name }}</a>
                                </div>
                                @endif
                                <div class="col-md-12 mb-3">
                                    <label>Message</label>
                                    <p>{{ $report->content }}</p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Status</label>
                                    <p>{{ $report->status }}</p>
                                </div>
                                <div class="col-md-12">
                                    <label>Evidence</label><br>
                                    <div class="row">
                                        @foreach (json_decode($report->picture, true) as $img)
                                            <div class="col-4 p-2">
                                                <img src="{{ asset($img) }}" class="img-fluid d-inline" alt="">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <a href="{{ route('super.reports.index') }}" class="btn btn-warning mr-2"><i
                                    class="right fas fa-angle-left"></i> Go Back</a>
                            <form id="response-form" method="POST"
                                action="{{ route('super.reports.respond', $report->encrypted_id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="reporter_id" value="{{ $report->created_by_user->encrypted_id }}">
                                <button type="submit" class="btn btn-primary">Respond</button>
                            </form>
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

    <div class="modal fade" id="confirm-response">
        <div class="modal-dialog">
            <div class="modal-content bg-success">
                <div class="modal-header">
                    <h4 class="modal-title">Respond to this report</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Please provide your response by typing it in the text area.
                    </p>

                    <div class="form-group">
                        <textarea class="form-control" type="text" id="response"></textarea>
                        <span id="err-msg"></span>
                    </div>
                    <!-- /.form-group -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button id="confirm-response-btn" type="button" class="btn btn-outline-light">Confirm</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@section('script')
    <script>
        const imageFile = $("#image");
        const preview = $("#img-preview");

        imageFile.on("change", function(e) {
            // Replace label inside input 
            const fileName = $(this).val();
            $(this).next(".custom-file-label").html(fileName);

            // Show image preview
            const item = e.target.files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function() {
                preview.attr("src", reader.result);
                preview.removeClass("d-none");
            }, false);

            if (item) {
                reader.readAsDataURL(item);
            }
        });

        $("#clear").click(function() {
            imageFile.val("");
            imageFile.next(".custom-file-label").html("Choose Image");
            preview.addClass("d-none");
            preview.attr("src", "#");
        });

        $("#response-form").on("submit", function(e) {
            e.preventDefault();
            $("#confirm-response").modal("show");
        });

        $("#confirm-response-btn").click(function() {
            let response = $("#response").val();
            if (response) {
                $(this).prop("disabled", true);
                $("#loading-modal").modal("show");
                $("#response-form").append('<input type="hidden" name="response" value="' + response + '">');   
                $("#response-form").unbind().submit();
            } else {
                $("#err-msg").text("Please type your response.");
            }
        });
    </script>
@endsection
