@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-navy font-weight-bold">Profile</h1>
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
                    <div class="card rounded shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('super.profile_update', Auth::user()->encrypted_id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="action" value="picture">
                                <span class="text-muted">Changes to your photo will be reflected across your
                                    account.</span>
                                <div class="form-group">
                                    <label>Profile Picture</label>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image" name="image"
                                                accept="image/*">
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
                                    <div>
                                        <div class="card p-2">
                                            <label for="img-preview">Preview</label>
                                            <img src="{{ !is_null(Auth::user()->profile_picture) ? asset(Auth::user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . Auth::user()->f_name . '+' . Auth::user()->l_name }}"
                                                id="img-preview"
                                                style="width: 150px; height: 150px; max-width: 150px; max-height: 150px;"
                                                class="img-fluid img-circle mx-auto" alt="preview">
                                        </div>
                                    </div>

                                </div>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('super.profile') }}" class="btn btn-warning mr-1">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script>
        $(document).ready(function() {
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
        });
    </script>
@endsection
