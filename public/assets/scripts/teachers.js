var url = $('body').attr('data-url');

function loadPagination(pagno) {
    $.ajax({
        url: url + '/profile/guru/' + pagno,
        type: 'get',
        dataType: 'json',
        success: function (response) {
            console.log(response)
            $("#pagination_link").html(response.message.pagination);
            
            show_table(response.message.result);
        },
        error: function (t) { 
            console.log(t.responseText);
        }
    });
}

$(document).ready(function () {

    loadPagination(1);

});

function show_table(response) {
    var trHTML = '';
    $.each(response, function (i, item) {

        var status = item.status == "active" ? "badge-success" : "badge-danger"
        trHTML += '<tr>' +
            '<td class="text-center text-muted">' + item.numberIdentity + '</td>' +
            '<td class="text-center">' +
            '<div class="widget-content p-0">' +
            '<div class="widget-content-wrapper">' +
            '<div class="widget-content-left flex2">' +
            '<div class="widget-heading">' + item.fullname + '</div>' +
            '<div class="widget-subheading opacity-7">' + item.position +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</td>' +
            '<td class="text-center">' + item.gender + '</td>' +
            '<td class="text-center">'+ item.bornOfDate +'</td>' +
            '<td class="text-center">'+ item.phone +'</td>' +
            '<td class="text-center">' +
            '<div class="badge ' + status +'">'+ item.status +'</div>'+
            '</td>'+
            '<td class="text-center">'+
            '<button type="button" id="btn-details" class="btn btn-primary btn-sm" data-field="'+ item.id +'" data-toggle="modal" data-target=".bd-example-modal-lg">' +
            '<i class="pe-7s-info">'+
            '</i></button>' +
            '<a type="button" id="btn-remove" class="btn btn-success btn-sm">' +
            '<i class="pe-7s-pen text-light">'+
            '</i></a>'+
            '<button type="button" id="btn-remove" class="btn btn-danger btn-sm">' +
            '<i class="pe-7s-trash">'+
            '</i></button>'+
            '</td>' +
            '</tr>';
    });
    $('#table_view').html(trHTML);
}


$(document).on("click", "#btn-details", function (event) {
    $.ajax({
        url: url + '/profile/guru/?id=' + $(this).attr('data-field'),
        type: 'get',
        dataType: 'json',
        success: function (response) {
            modal_detail(response.message)
        },
        error: function (t) { 
            console.log(t);
        }
    });
});

function modal_detail(response)
{
    var photo = response.profilePhoto === 'http://localhost/learning/public/' ? 'http://localhost/learning/public/upload/profile/default.jpg' : response.profilePhoto;
    
    $('#username').text(response.username)
    $('#email').text(response.email)
    $('#identity').text(response.numberIdentity)
    $('#fullname').text(response.fullname)
    $('#position').text(response.position)
    $('#bod').text(response.bornOfDate)
    $('#gender').text(response.gender)
    $('#religion').text(response.religion)
    $('#address').text(response.address.address)
    $('#city').text(response.address.city)
    $('#state').text(response.address.state)
    $('#zip').text(response.address.zip)
    $('#phone').text(response.phone)
    $("#photo").attr("src", photo);
}

$(document).on("click", ".pagination li a", function (event) {
    event.preventDefault();
    var page = $(this).data("ci-pagination-page");
    loadPagination(page);
});