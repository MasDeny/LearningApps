<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Soal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="position-relative form-group text-center">
                            <p class="value_input" style="display: none;"></p>
                            <h5><strong>Soal Pertanyaa</strong></h5>
                            <p id="soal"></p>
                            <span id="math-field" class="w-100 mb-2"></span>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="position-relative form-group text-center">
                            <h5><strong>Lihat Rumus :</strong></h5>
                            <p class="MathOutput" style="display: none;"> $ \text{ preview } $</p>
                            <a class="btn bg-white" id="preview">
                                <i class="fa fa-fw" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="add_math">Tambahkan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/x-mathjax-config">
    MathJax.Hub.Config({
                tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
            });
        </script>
<script type="text/javascript" async src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.7/MathJax.js?config=TeX-MML-AM_CHTML">
</script>