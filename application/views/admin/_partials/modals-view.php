<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-arielle-smile text-light">
                <h5 class="modal-title" id="exampleModalLongTitle">Detail Murid</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center mb-auto pb-1">
                            <img class="img-fluid rounded" src="" id="photo" style="height: 65%; width:auto;" >
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="input-group col-sm-6 pb-2">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary">Username : </button>
                                    </div>
                                    <p class="form-control" id="username"></p>
                                </div>
                                <div class="input-group col-sm-6 pb-2" style="margin-left: -20px;">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary">Email : </button>
                                    </div>
                                    <p class="form-control" id="email"></p>
                                </div>
                                <div class="input-group col-sm-6 pb-2">
                                    <div class="input-group-prepend">
                                    <?php if($this->uri->segment(3)=='murid'){?>
                                        <button class="btn btn-secondary">NIS : </button>
                                    <?php }else{ ?>
                                        <button class="btn btn-secondary">NIP : </button>
                                    <?php } ?>
                                    </div>
                                    <p class="form-control" id="identity"> TKL-456 </p>
                                </div>
                                <div class="input-group col-sm-6 pb-2" style="margin-left: -20px;">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary">Nama Lengkap : </button>
                                    </div>
                                    <p class="form-control" id="fullname"></p>
                                </div>
                                <?php if ($this->uri->segment(3)=='murid') { ?>
                                <div class="input-group col-sm-6 pb-2">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary">Kelas : </button>
                                    </div>
                                    <p class="form-control" id="class"></p>
                                </div>
                                <div class="input-group col-sm-6 pb-2" style="margin-left: -20px;">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary">TTL : </button>
                                    </div>
                                    <p class="form-control" id="bod"></p>
                                </div>
                                <?php }else{ ?>
                                    <div class="input-group col-sm-6 pb-2">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary">Posisi : </button>
                                    </div>
                                    <p class="form-control" id="position"></p>
                                </div>
                                <div class="input-group col-sm-6 pb-2" style="margin-left: -20px;">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary">TTL : </button>
                                    </div>
                                    <p class="form-control" id="bod"></p>
                                </div>
                                <?php } ?>
                                <div class="input-group col-sm-6 pb-2">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary">Jenis Kelamin : </button>
                                    </div>
                                    <p class="form-control" id="gender"></p>
                                </div>
                                <div class="input-group col-sm-6 pb-2" style="margin-left: -20px;">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary">Agama : </button>
                                    </div>
                                    <p class="form-control" id="religion"></p>
                                </div>
                                <div class="input-group col-sm-12 pb-2" style="padding-right: 35px;">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary">Alamat : </button>
                                    </div>
                                    <p class="form-control"  id="address"></p>
                                </div>
                                <div class="input-group col-sm-6 pb-2">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary">Kota : </button>
                                    </div>
                                    <p class="form-control" id="city"> </p>
                                </div>
                                <div class="input-group col-sm-6 pb-2" style="margin-left: -20px;">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary">Provinsi : </button>
                                    </div>
                                    <p class="form-control" id="state"></p>
                                </div>
                                <div class="input-group col-sm-6 pb-2">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary">Kode Pos : </button>
                                    </div>
                                    <p class="form-control" id="zip"></p>
                                </div>
                                <div class="input-group col-sm-6 pb-2" style="margin-left: -20px;">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary">Nomer Telepon : </button>
                                    </div>
                                    <p class="form-control" id="phone"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>