<div class="col-lg-12">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center mb-auto pb-1">
            <div class="position-relative form-group" id="photo">
                <label for="exampleAddress" class="">Upload Foto Profile</label>
            </div>
        </div>
        <div class="col-md-12">
            <form id="submit" url="<?php echo base_url() ?>" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="input-group col-sm-6 pb-2">
                        <div class="input-group-prepend">
                            <button class="btn btn-secondary">Username : </button>
                        </div>
                        <input class="form-control" id="username">
                    </div>
                    <div class="input-group col-sm-6 pb-2" style="margin-left: -20px;">
                        <div class="input-group-prepend">
                            <button class="btn btn-secondary">Email : </button>
                        </div>
                        <input class="form-control" id="email">
                    </div>
                    <div class="input-group col-sm-6 pb-2">
                        <div class="input-group-prepend">
                            <?php if ($this->uri->segment(3) == 'murid') { ?>
                                <button class="btn btn-secondary">NIS : </button>
                            <?php } else { ?>
                                <button class="btn btn-secondary">NIP : </button>
                            <?php } ?>
                        </div>
                        <input class="form-control" id="identity">
                    </div>
                    <div class="input-group col-sm-6 pb-2" style="margin-left: -20px;">
                        <div class="input-group-prepend">
                            <button class="btn btn-secondary">Nama Lengkap : </button>
                        </div>
                        <input class="form-control" id="fullname">
                    </div>
                    <?php if ($this->uri->segment(3) == 'murid') { ?>
                        <div class="input-group col-sm-6 pb-2">
                            <div class="input-group-prepend">
                                <button class="btn btn-secondary">Tahun masuk : </button>
                            </div>
                            <input class="form-control" id="years">
                        </div>

                    <?php } else { ?>
                        <div class="input-group col-sm-6 pb-2">
                            <div class="input-group-prepend">
                                <button class="btn btn-secondary">Posisi : </button>
                            </div>
                            <input class="form-control" id="position">
                        </div>
                    <?php } ?>
                    <div class="input-group col-sm-6 pb-2" style="margin-left: -20px;">
                        <div class="input-group-prepend">
                            <button class="btn btn-secondary">TTL : </button>
                        </div>
                        <input class="form-control" id="bod">
                    </div>
                    <div class="input-group col-sm-6 pb-2">
                        <div class="input-group-prepend">
                            <button class="btn btn-secondary">Jenis Kelamin : </button>
                        </div>
                        <input class="form-control" id="gender">
                    </div>
                    <div class="input-group col-sm-6 pb-2" style="margin-left: -20px;">
                        <div class="input-group-prepend">
                            <button class="btn btn-secondary">Agama : </button>
                        </div>
                        <input class="form-control" id="religion">
                    </div>
                    <div class="input-group col-sm-12 pb-2" style="padding-right: 25px;">
                        <div class="input-group-prepend">
                            <button class="btn btn-secondary">Alamat : </button>
                        </div>
                        <input class="form-control" id="address">
                    </div>
                    <div class="input-group col-sm-6 pb-2">
                        <div class="input-group-prepend">
                            <button class="btn btn-secondary">Kota : </button>
                        </div>
                        <input class="form-control" id="city">
                    </div>
                    <div class="input-group col-sm-6 pb-2" style="margin-left: -20px;">
                        <div class="input-group-prepend">
                            <button class="btn btn-secondary">Provinsi : </button>
                        </div>
                        <input class="form-control" id="state">
                    </div>
                    <div class="input-group col-sm-6 pb-2">
                        <div class="input-group-prepend">
                            <button class="btn btn-secondary">Kode Pos : </button>
                        </div>
                        <input class="form-control" id="zip">
                    </div>
                    <div class="input-group col-sm-6 pb-2" style="margin-left: -20px;">
                        <div class="input-group-prepend">
                            <button class="btn btn-secondary">Nomer Telepon : </button>
                        </div>
                        <input class="form-control" id="phone">
                    </div>
                    <div class="col-md-5 ml-md-auto text-right pr-4 pt-2">
                        <button class="btn text-light bg-info" id="submit-edit" type="submit">
                            <h6>Simpan perubahan</h6>
                        </button>
                        <button class="btn text-light bg-secondary" data-dismiss="modal" aria-label="Close">
                            <h6>Batalkan</h6>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>