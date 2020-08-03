$(document).ready(function () {

    $('#smartwizard').smartWizard({
        selected: 0,
        theme: 'progress',
        autoAdjustHeight: true,
        transition: {
            animation: 'slide-swing', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
            speed: '800', // Transion animation speed
        },
        showStepURLhash: true,
        justified: true,
        keyboardSettings: {
            keyNavigation: false
        }

    });

    $(function () {
        var formula = '';
        operation = function (math) {
            formula += math;
            $("#target").get(0).innerHTML = '$' + formula + '$';
            var math = document.getElementById("target");
            MathJax.Hub.Queue(["Typeset",MathJax.Hub,math]);
        };
    })

    var drEvent = $(".dropify").dropify({
        messages: { default : 'klik untuk tambah dokumen', error: "Ooops, something wrong happended." }, error: { fileSize: "Ukuran file terlalu besar, maksimal ({{ value }}).", fileExtension: "Format file tidak diijinkan, untuk format ({{ value }})." }, wrap: '<div class="dropify-wrapper"></div>',
        loader: '<div class="dropify-loader"></div>',
    });

    drEvent = drEvent.data('dropify');
    drEvent.resetPreview();
    drEvent.clearElement();
    drEvent.data.height(300);
    drEvent.destroy();
    drEvent.init();

    console.log('awal')

    $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
        console.log(e)
      });
});