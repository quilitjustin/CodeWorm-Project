@extends('layouts.web.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-navy font-weight-bold">Profile</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item active">Settings</li>
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
                        <div class="card rounded shadow-sm">
        <div class="card-body">
            <table class="table table-hover" id="settings">
                <tbody>
                    <tr id="name">
                        <th scope="row">Name</th>
                        <td>John Doe</td>
                        <td>@mdo</td>
                    </tr>
                    <tr class="item">
                        <th scope="row">Email</th>
                        <td>some@gmail.com</td>
                        <td>@fat</td>
                    </tr>
                    <tr class="item">
                        <th scope="row">Password</th>
                        <td>********</td>
                        <td>@twitter</td>
                    </tr>
                </tbody>
            </table>
            <div>
        <form action="{{ route('web.profile') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label>First Name</label>
                <input type="text" name="f_name">
            </div>
            <div class="form-group mb-3">
                <label>Last Name</label>
                <input type="text" name="l_name">
            </div>
            <div class="text-left">
                <button id="cancel" class="btn btn-warning">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
        </div>
    </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('script')
    <script>
        $("#name").click(function(){
             
        });
    
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
    </script>
@endsection
