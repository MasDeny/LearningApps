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
                        <div class="col-md-12 d-flex justify-content-center mb-auto pb-4">
                        <input id="photo-preview" class="form-control dropify-view" data-show-loader="false" data-height="190" data-show-remove="false" height="500">
                        </div>
                        <div class="col-md-12 d-flex justify-content-center">
                            <div class="row">
                                <div class="input-group col-sm-6 pb-2">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary sl">Username : </button>
                                    </div>
                                    <p class="form-control" id="username-view"></p>
                                </div>
                                <div class="input-group col-sm-6 pb-2" style="margin-left: -20px;">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary sl">Email : </button>
                                    </div>
                                    <p class="form-control" id="email-view"></p>
                                </div>
                                <div class="input-group col-sm-6 pb-2">
                                    <div class="input-group-prepend">
                                    <?php if($this->uri->segment(3)=='murid'){?>
                                        <button class="btn btn-secondary sl">NIS : </button>
                                    <?php }else{ ?>
                                        <button class="btn btn-secondary sl">NIP : </button>
                                    <?php } ?>
                                    </div>
                                    <p class="form-control" id="identity-view"></p>
                                </div>
                                <div class="input-group col-sm-6 pb-2" style="margin-left: -20px;">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary sl">Nama Lengkap : </button>
                                    </div>
                                    <p class="form-control" id="fullname-view"></p>
                                </div>
                                <?php if ($this->uri->segment(3)=='murid') { ?>
                                <div class="input-group col-sm-6 pb-2">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary sl">Tahun masuk : </button>
                                    </div>
                                    <p class="form-control" id="years-view"></p>
                                </div>
                                
                                <?php }else{ ?>
                                    <div class="input-group col-sm-6 pb-2">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary sl">Posisi : </button>
                                    </div>
                                    <p class="form-control" id="position-view"></p>
                                </div>
                                <?php } ?>
                                <div class="input-group col-sm-6 pb-2" style="margin-left: -20px;">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary sl">TTL : </button>
                                    </div>
                                    <p class="form-control" id="bod-view"></p>
                                </div>
                                <div class="input-group col-sm-6 pb-2">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary sl">Jenis Kelamin : </button>
                                    </div>
                                    <p class="form-control" id="gender-view"></p>
                                </div>
                                <div class="input-group col-sm-6 pb-2" style="margin-left: -20px;">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary sl">Agama : </button>
                                    </div>
                                    <p class="form-control" id="religion-view"></p>
                                </div>
                                <div class="input-group col-sm-12 pb-2" style="padding-right: 35px;">
                                    <div class="input-group-prepend ll">
                                        <button class="btn btn-secondary ll">Alamat : </button>
                                    </div>
                                    <p class="form-control"  id="address-view"></p>
                                </div>
                                <div class="input-group col-sm-6 pb-2">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary sl">Kota : </button>
                                    </div>
                                    <p class="form-control" id="city-view"> </p>
                                </div>
                                <div class="input-group col-sm-6 pb-2" style="margin-left: -20px;">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary sl">Provinsi : </button>
                                    </div>
                                    <p class="form-control" id="state-view"></p>
                                </div>
                                <div class="input-group col-sm-6 pb-2">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary sl">Kode Pos : </button>
                                    </div>
                                    <p class="form-control" id="zip-view"></p>
                                </div>
                                <div class="input-group col-sm-6 pb-2" style="margin-left: -20px;">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-secondary">Nomer Telepon : </button>
                                    </div>
                                    <p class="form-control" id="phone-view"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>