<div class="col-md-3">
    @if (request()->is('inquiries/*'))
        <button onclick="history.back();" class="btn btn-primary btn-block mb-3">Back to Inbox</button>
    @endif


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Folders</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item active">
                    <a href="#" class="nav-link">
                        <i class="fas fa-inbox"></i> Inbox
                        <span class="badge bg-primary float-right">12</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-envelope"></i> Sent
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-file-alt"></i> Drafts
                    </a>
                </li>
            </ul>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</div>
<!-- /.col -->
