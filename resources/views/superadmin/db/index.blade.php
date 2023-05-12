@extends('layouts.superadmin.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-navy font-weight-bold d-inline mr-1">Export</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('super.db.index') }}">Export</a></li>
                        <li class="breadcrumb-item active">Index</li>
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
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#import" data-toggle="tab">Import</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#export" data-toggle="tab">Export</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="import">
                                    <form action="{{ route('super.db.import') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label>Upload SQL file</label>
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="sql_file"
                                                        name="sql_file">
                                                    <label class="custom-file-label" for="sql_file"
                                                        aria-describedby="inputGroupFileAddon02">Choose SQL file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <button type="button" id="clear"
                                                        class="btn btn-outline-secondary">Clear</button>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end align-items-center">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                            @error('sql_file')
                                                <p class="text-danger my-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- /.form-group -->
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="export">
                                    <a href="{{ route('super.db.export') }}" class="btn btn-outline-primary">Export SQL
                                        file</a>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
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
@endsection

@section('script')
    <script>
        const sqlFile = $("#sql_file");

        sqlFile.on("change", function(e) {
            // Replace label inside input 
            const fileName = $(this).val();
            $(this).next(".custom-file-label").html(fileName);
        });

        $("#clear").click(function() {
            sqlFile.val("");
            sqlFile.next(".custom-file-label").html("Choose Image");
        });
    </script>
@endsection
