<div class="col-lg-12 pt-3">
    <div class="row">
        <form id="edit-profile" url="<?php echo base_url() ?>" enctype="multipart/form-data">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="position-relative input-group col-sm-12 pb-4" id="photo">
                        <input name="file" id="file" type="file" class="form-control dropify" accept="image/*" data-max-file-size="1M" data-height="180" data-allowed-file-extensions="jpg jpeg png bmp" data-errors-position="outside" data-show-remove="false">
                    </div>
                    <div class="input-group col-sm-6 pb-3">
                        <div class="input-group-prepend">
                            <a class="btn btn-secondary sl text-light">Username : </a>
                        </div>
                        <input class="form-control caps" id="username" name="username">
                    </div>
                    <div class="input-group col-sm-6 pb-3">
                        <div class="input-group-prepend">
                            <a class="btn btn-secondary sl text-light">Email : </a>
                        </div>
                        <input class="form-control caps" name="email" type="email">
                    </div>
                    <div class="input-group col-sm-6 pb-3">
                        <div class="input-group-prepend">
                            <?php if ($this->uri->segment(3) == 'murid') { ?>
                                <a class="btn btn-secondary sl text-light">NIS : </a>
                            <?php } else { ?>
                                <a class="btn btn-secondary sl text-light">NIP : </a>
                            <?php } ?>
                        </div>
                        <input class="form-control upper" name="id">
                    </div>
                    <?php if ($this->uri->segment(3) == 'murid') { ?>
                        <div class="input-group col-sm-6 pb-3">
                            <div class="input-group-prepend">
                                <a class="btn btn-secondary sl text-light">Nama Lengkap : </a>
                            </div>
                            <input class="form-control caps" name="fullname">
                        </div>
                        <div class="input-group col-sm-6 pb-3">
                            <div class="input-group-prepend">
                                <a class="btn btn-secondary sl text-light">Tahun masuk : </a>
                            </div>
                            <input class="form-control" name="years">
                        </div>
                        <div class="input-group col-sm-6 pb-3">
                            <div class="input-group-prepend">
                                <a class="btn btn-secondary sl text-light">Kelas : </a>
                            </div>
                            <input class="form-control" type="number" name="class">
                        </div>
                    <?php } else { ?>
                        <div class="input-group col-sm-6 pb-3">
                            <div class="input-group-prepend">
                                <a class="btn btn-secondary sl text-light">Posisi : </a>
                            </div>
                            <input class="form-control caps" name="position">
                        </div>
                        <div class="input-group col-sm-12 pb-3" tyle="padding-right: 5px;">
                            <div class="input-group-prepend ll">
                                <a class="btn btn-secondary ll text-light">Nama Lengkap : </a>
                            </div>
                            <input class="form-control caps" name="fullname">
                        </div>
                    <?php } ?>
                    <div class="input-group col-sm-6 pb-3">
                        <div class="input-group-prepend">
                            <a class="btn btn-secondary sl text-light">Tempat Lahir : </a>
                        </div>
                        <input class="form-control caps" name="place">
                    </div>
                    <div class="input-group col-sm-6 pb-3">
                        <div class="input-group-prepend">
                            <a class="btn btn-secondary sl text-light">Tanggal Lahir : </a>
                        </div>
                        <input class="form-control" name="date">
                    </div>
                    <div class="input-group col-sm-6 pb-3">
                        <div class="input-group-prepend">
                            <a class="btn btn-secondary sl text-light">Jenis Kelamin : </a>
                        </div>
                        <input class="form-control" name="gender">
                    </div>
                    <div class="input-group col-sm-6 pb-3">
                        <div class="input-group-prepend">
                            <a class="btn btn-secondary sl text-light">Agama : </a>
                        </div>
                        <input class="form-control caps" name="religion">
                    </div>
                    <div class="input-group col-sm-12 pb-3" style="padding-right: 5px;">
                        <div class="input-group-prepend ll">
                            <a class="btn btn-secondary ll text-light">Alamat : </a>
                        </div>
                        <input class="form-control caps" name="address">
                    </div>
                    <div class="input-group col-sm-6 pb-3">
                        <div class="input-group-prepend">
                            <a class="btn btn-secondary sl text-light text-light">Kota : </a>
                        </div>
                        <input class="form-control caps" name="city">
                    </div>
                    <div class="input-group col-sm-6 pb-3">
                        <div class="input-group-prepend">
                            <a class="btn btn-secondary sl text-light">Provinsi : </a>
                        </div>
                        <input class="form-control caps" name="state">
                    </div>
                    <div class="input-group col-sm-6 pb-3">
                        <div class="input-group-prepend">
                            <a class="btn btn-secondary sl text-light">Kode Pos : </a>
                        </div>
                        <input class="form-control" type="number" name="zip">
                    </div>
                    <div class="input-group col-sm-6 pb-3">
                        <div class="input-group-prepend">
                            <a class="btn btn-secondary sl text-light">Nomer Telepon : </a>
                        </div>
                        <input class="form-control" type="number" name="phone">
                    </div>
                    <div class="col-md-5 ml-md-auto text-right pr-1 pt-2">
                        <button class="btn text-light bg-info" id="submit-edit" type="submit">
                            <h6>Simpan</h6>
                        </button>
                        <button class="btn text-light bg-secondary" data-dismiss="modal" aria-label="Close">
                            <h6>Batalkan</h6>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>