<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambahkan Rumus Matematika</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="position-relative form-group text-center">
                            <p class="value_input" style="display: none;"></p>
                            <h5><strong>Tulis rumus matematika :</strong></h5>
                            <p>Untuk melihat cara penulisan silahkan klik <a target="_blank" href="https://kapeli.com/cheat_sheets/LaTeX_Math_Symbols.docset/Contents/Resources/Documents/index"> link berikut </a> </p>
                            <span id="math-field" class="w-100 mb-2"></span>
                            <br>
                            <p class="text-center">Tampilan Latex :</p>
                            <h5 class="text-center"><strong><span id="latex"></span></strong></h5>
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
<script>
    var MQ = MathQuill.noConflict().getInterface(2); // for backcompat
    var mathFieldSpan = document.getElementById('math-field');
    var latexSpan = document.getElementById('latex');
    var mathField = MQ.MathField(mathFieldSpan, {
        spaceBehavesLikeTab: true, // configurable
        handlers: {
            edit: function() { // useful event handlers
                latexSpan.textContent = mathField.latex(); // simple API
            }
        }
    });
</script>
<script>
    $(document).on("focus", "#math-field", function() {
        $('.MathOutput').hide();
    });
    $(document).on("click", "#preview", function() {
        $('.MathOutput').show();
        var QUEUE = MathJax.Hub.queue; // shorthand for the queue
        var math = null;

        QUEUE.Push(function() {
            math = MathJax.Hub.getAllJax("MathOutput")[0];
            MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
        });
        const field = $('#latex').text();
        var TeX = document.getElementById('latex').innerHTML;
        QUEUE.Push(["Text", math, "\\displaystyle{" + TeX + "}"]);
    });
    $(document).on("click", "#add_math", function() {

        const field = $('#latex').text();
        const quest = $('.value_input').text();
        const name = $('.value_input').attr('id');
        if (name == 'question') {
            $('textarea[name=' + name + ']').val(quest + ' $ ' + field + ' $')
        } else {
            $('input[name=' + name + ']').val(quest + ' $ ' + field + ' $')
        }
    });
</script>