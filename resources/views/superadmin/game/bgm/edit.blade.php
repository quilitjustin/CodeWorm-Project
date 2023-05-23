@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                     <h1 class="m-0 text-navy font-weight-bold d-inline mr-1">Background Musics</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('super.bgms.index') }}">BGM</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                                Background Music Details
                            </h3>
                        </div>
                        <form method="POST" action="{{ route('super.bgms.update', $bgm->encrypted_id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" value="false" id="action" name="action">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" type="text" name="name"
                                                placeholder="Enter name" value="{{ old('name', $bgm['name']) }}" />
                                            @error('name')
                                                <p class="text-danger my-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Audio</label>
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="audio"
                                                        name="audio" accept="audio/*">
                                                    <label class="custom-file-label" for="audio"
                                                        aria-describedby="inputGroupFileAddon02">Choose Audio</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <button type="button" id="clear"
                                                        class="btn btn-outline-secondary">Clear</button>
                                                </div>
                                            </div>
                                            <span class="text-sm text-danger">Note: only upload audio if you want to update
                                                the audio</span>
                                            @error('audio')
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
                                <a href="{{ route('super.bgms.index') }}" class="btn btn-warning">Cancel</a>
                                <button type="submit" class="btn btn-primary ml-2">Update</button>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-12">
                    <div class="card p-2">
                        <label for="audio-preview">Preview</label>
                        <audio src="#" id="audio-preview" class="d-none w-100" controls></audio>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection

@section('script')
    <script>
        const rule = $("#action");
        const audioFile = $("#audio");
        const preview = $("#audio-preview");

        audioFile.on("change", function(e) {
            // The audio has been updated
            rule.val("true");

            // Replace label inside input 
            const fileName = $(this).val();
            $(this).next(".custom-file-label").html(fileName);

            // Show audio preview
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

        $("#clear").click(function(e) {
            // The audio has been removed
            rule.val("false");
            audioFile.val("");
            audioFile.next(".custom-file-label").html("Choose audio");
            preview.addClass("d-none");
            preview.attr("src", "#");
        });
    </script>
@endsection
