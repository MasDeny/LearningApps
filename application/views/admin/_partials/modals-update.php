<div class="modal fade bd-edit-modal-lg" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-arielle-smile text-light">
                <h5 class="modal-title" id="exampleModalLongTitle">Detail Murid</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <ul class="tabs-animated-shadow nav-justified tabs-animated nav">
                    <li class="nav-item">
                        <a role="tab" class="nav-link active" id="tab-c1-0" data-toggle="tab" href="#tab-animated1-0">
                            <span class="nav-text">Pembaharuan Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a role="tab" class="nav-link" id="tab-c1-1" data-toggle="tab" href="#tab-animated1-1">
                            <span class="nav-text">Atur Ulang Password</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content" style="min-height:300px">
                    <div class="tab-pane active" id="tab-animated1-0" role="tabpanel">
                        <?php $this->load->view("admin/AdminMenu/editprofile.php") ?>
                    </div>
                    <div class="tab-pane" id="tab-animated1-1" role="tabpanel">
                    <?php $this->load->view("admin/AdminMenu/resetpassword.php") ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>