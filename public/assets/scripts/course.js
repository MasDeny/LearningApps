var url = $('body').attr('data-url');
var a = 1
$(document).ready(function () {

    loadDataCourse(1, a)
});

$('a[data-toggle=tab]').click(function () {
    switch (this.id) {
        case 'kelas-2':
            a = 2
            loadDataCourse(1, a)
            break;
        case 'kelas-3':
            a = 3
            loadDataCourse(1, a)
            break;
        default:
            a = 1
            loadDataCourse(1, a)
    }
});

$(document).on("click", ".pagination li a", function (event) {
    event.preventDefault();
    var page = $(this).data("ci-pagination-page");
    loadDataCourse(page, a);
});

function loadDataCourse(pagno, b) {
    var link = url + 'api/course/' + pagno + '?class=' + b
    $.ajax({
        url: link,
        type: 'get',
        dataType: 'json',
        success: function (response) {
            $("#pagination_link").html(response.pagination);
            show_content(response.result, b);
        },
        error: function (t) {
            console.log(t);
        }
    });
}

function show_content(response, b) {
    var trHTML = '';
    $.each(response, function (i, item) {
        trHTML += '<div class="col-lg-6 col-xl-4 pb-2">' +
            '<div class="card-body widget-content shadow border-dark">' +
            '<div class="text-right">' +
            '<a target="_blank" rel="noopener noreferrer" href="' + item.content + '" class="btn bg-white text-dark text-right">' +
            '<i class="fa fa-fw" aria-hidden="true" title="lihat pdf"></i>' +
            '</a >' +
            '</div >' +
            '<div class="text-center">' +
            '<img class="card-img-top" src="' + url + 'assets/images/pdf.png" style="width:105px;height:105px;">' +
            '</div>' +
            '<div class="card-body text-left">' +
            '<div class="widget-content-wrapper">' +
            '<div class="widget-content-left">' +
            '<div class="widget-heading text-info">' + item.category + '</div>' +
            '<div class="widget-heading text-secondary">Level ' + item.level + '</div>' +
            '<div class="widget-heading">' + item.chapter + '</div>' +
            '</div>' +
            '<div class="widget-content-right">' +
            '<div class="widget-subheading">Poin Nilai</div>' +
            '<div class="widget-numbers text-success text-center">' +
            '<span>' + item.point + '</span>' +
            '</div> ' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="card-body widget-content shadow bg-secondary text-light">' +
            '<div class="text-right">' +
            '<a href="" class="btn bg-info text-light m-1">' +
            '<i class="fa fa-fw" aria-hidden="true" title="Edit Materi"></i>' +
            '</a>' +
            '<a href="" class="btn btn-danger m-1">' +
            '<i class="fa fa-fw" aria-hidden="true" title="Hapus Materi"></i>' + '</a>' +
            '</div>' +
            '</div>' +
            '</div>';
    });
    $('#course-content-' + b).html(trHTML);
}