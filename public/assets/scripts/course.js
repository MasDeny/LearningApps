var url = $('body').attr('data-url');
$(document).ready(function () {

    // loadDataCourse(1);
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href") // activated tab
        alert(target);
      });
});

function loadDataCourse(pagno) {
    if (SClass != '') {
        var link = url + '/profile/murid/' + pagno + '?class=' + SClass
    } else {
        var link = url + '/profile/murid/' + pagno
    }
    $.ajax({
        url: link,
        type: 'get',
        dataType: 'json',
        success: function (response) {

            $("#pagination_link").html(response.message.pagination);

            show_table(response.message.result);
        },
        error: function (t) {
            console.log(t);
        }
    });
}