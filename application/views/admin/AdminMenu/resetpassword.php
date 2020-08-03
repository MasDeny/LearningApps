<div class="col-lg-12 pt-5 d-flex justify-content-center">
    <div class="row">
        <form id="pass-change" url="<?php echo base_url() ?>" data-id-user="" enctype="multipart/form-data">
            <div class="col-lg-12">
                <div class="form-row">
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
                        <input class="form-control" name="email" type="email">
                    </div>
                    <div class="input-group col-sm-6 pb-3">
                        <div class="input-group-prepend">
                            <a class="btn btn-secondary sl text-light">Password : </a>
                        </div>
                        <input class="form-control" name="password" type="password">
                    </div>
                    <div class="input-group col-sm-6 pb-3">
                        <div class="input-group-prepend">
                            <a class="btn btn-secondary sl text-light">Ulangi Password : </a>
                        </div>
                        <input class="form-control" name="password_confirm" type="password">
                        <div class="input-group-append" id="show-pass">
                            <a class="input-group-text btn">
                                <i class="pe-7s-look"> </i>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-5 ml-md-auto text-right pr-1 pt-4">
                        <button class="btn text-light bg-info" id="submit-pass" type="submit">
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