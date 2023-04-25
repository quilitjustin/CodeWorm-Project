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
                        <a href="{{ route('super.cms.logo.create') }}" class="btn btn-primary">Upload New Image</a>
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
                                <button id="delete" class="btn btn-outline-danger">Delete</button>
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

<div class="modal fade" id="confirm-delete">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Deletion</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Are you sure you want to delete this image?
                    <br>
                    Important Reminder: This image will be permanently deleted.
                </p>

                <div class="form-group">
                    <label>
                        If you understand the risks and still wish to proceed.
                        <br>
                        Please type "<span id="condition">I understand</span>"
                    </label>
                    <input class="form-control" type="text" id="confirmation" placeholder="Please confirm" />
                    <span id="err-msg"></span>
                </div>
                <!-- /.form-group -->
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                <button id="confirm-btn" type="button" class="btn btn-outline-light">Confirm</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

