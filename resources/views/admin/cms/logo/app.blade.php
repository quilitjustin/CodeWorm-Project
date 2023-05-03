<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div id="images" class="col-12">
                <div class="card card-navy">
                    <div class="card-header">
                        <h3 class="card-title">Available Images</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            @forelse ($cmsbgims as $cmsbgim)
                                <div class="img-toggle col-md-4 p-2 d-flex justify-content-center align-items-center">
                                    <img src="{{ asset($cmsbgim->path) }}" style="height: 150px; max-height: 150px"
                                        alt="picture">
                                </div>
                            @empty
                                No Records
                            @endforelse
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <a href="{{ route('admin.cms.logo.create') }}" class="btn btn-primary">Upload New Image</a>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div id="settings" class="col-md-6 d-none">
                <div class="card card-navy">
                    <div class="card-header">
                        <h3 class="card-title">Image Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-secondary">
                                <div class="img-toggle col-md-4 p-2 d-flex justify-content-center align-items-center">
                                    <img id="img-preview" src="#" style="height: 150px; max-height: 150px"
                                        alt="picture">
                                </div>
                                <p>
                                    Creted By:
                                    <span id="created-by"></span>
                                    <br>
                                    Date of Creation:
                                    <span id="created-at"></span>
                                </p>
                                <button id="set-bg" class="btn btn-primary mr-3">Set as Logo</button>
                                
                            </div>
                        </div>
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


