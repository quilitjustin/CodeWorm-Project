@extends('layouts.web.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper"
        style="background-image: url('{{ asset('assets/bgim/report.png') . '?v=' . filemtime(public_path('assets/bgim/announcement.png')) }}'); background-repeat: no-repeat; background-position: center; background-attachment: fixed; background-size: cover;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-navy font-weight-bold d-inline mr-1">Report</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">

                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-12">
                        <div class="card card-navy">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Background Image Details
                                </h3>
                            </div>
                            <form method="POST" action="{{ route('web.reports.store') }}" enctype="multipart/form-data">
                                @csrf
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Image</label>
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="image"
                                                            name="image[]" accept="image/*" multiple>
                                                        <label class="custom-file-label" for="image"
                                                            aria-describedby="inputGroupFileAddon02">Choose Image</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <button type="button" id="clear"
                                                            class="btn btn-outline-secondary">Clear</button>
                                                    </div>
                                                </div>
                                                @error('image')
                                                    <p class="text-danger my-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <!-- /.form-group -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Details</label>
                                                <textarea class="form-control" name="content">{{ old('content') }}</textarea>
                                                @error('content')
                                                    <p class="text-danger my-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <!-- /.form-group -->
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary ml-2">Submit</button>
                                </div>
                                <!-- /.card-footer -->
                            </form>
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

@section('script')
    <script>
        const imageFile = $("#image");
        const preview = $("#img-preview");

        imageFile.on("change", function(e) {
            // Replace label inside input
            const fileNames = [];
            for (let i = 0; i < this.files.length; i++) {
                fileNames.push(this.files[i].name);
            }
            $(this).next(".custom-file-label").html(fileNames.join(", "));

            // Show image previews
            const files = e.target.files;
            const previewContainer = $(".preview-container");
            previewContainer.empty(); // Clear existing previews

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.addEventListener("load", function() {
                    // Create an image element for the preview
                    const imgElement = $("<img>").attr("src", reader.result);
                    previewContainer.append(imgElement);
                }, false);

                if (file) {
                    reader.readAsDataURL(file);
                }
            }
        });


        $("#clear").click(function() {
            imageFile.val("");
            imageFile.next(".custom-file-label").html("Choose Image");
            preview.addClass("d-none");
            preview.attr("src", "#");
        });
    </script>
@endsection
