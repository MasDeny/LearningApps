var url = $("body").attr("data-url");
var type = $("body").attr("data-type");

$(document).ready(function () {
	loadPagination(1);
});

function loadPagination(pagno) {
	if (type == "pretestexam") {
		var link = url + "api/exam/1/" + pagno;
	} else if (type == "finalexam") {
		var link = url + "api/exam/2/" + pagno;
	} else {
		var link = url + "api/exam/3/" + pagno;
	}

	$.ajax({
		url: link,
		type: "get",
		dataType: "json",
		success: function (response) {
			console.log(response);
			$("#pagination_link").html(response.result.pagination);
            show_table(response.result.result);
		},
		error: function (t) {
			console.log(t);
		},
	});
}

function show_table(response) {
	// var datarole = "";
	// if (role == "guru") {
	// 	datarole +=
	// 		'<a type="button" id="btn-statistik" class="btn btn-warning btn-sm ml-1" data-toggle="tooltip" data-placement="top" title="Statistik Siswa">' +
	// 		'<i class="pe-7s-graph1 text-light">' +
	// 		"</i></a>";
	// }
	var trHTML = "";
	$.each(response, function (i, item) {
		var status = item.status == "1" ? "badge-success" : "badge-danger";
		var locked = item.status == "active" ? "lock" : "unlock";
		var text = item.status == "1" ? "active" : item.status == "2" ? "expired" : "deactive" ;
        var numb = i+1
		trHTML +=
			"<tr>" +
			'<td class="text-center text-muted" >' +
			numb +
			"</td>" +
			'<td class="text-center">' +
			item.nama_guru +
			"</td>" +
			'<td class="text-center">' +
			item.jenis_soal +
			"</td>" +
			'<td class="text-center">' +
			item.class +
			"</td>" +
			'<td class="text-center">' +
			item.level +
			"</td>" +
			'<td class="text-center">' +
			'<div class="badge ' +
			status +
			'">' +
			text +
			"</div>" +
			"</td>" +
			'<td class="text-center">' +
			// '<button type="button" id="btn-details" class="btn btn-primary btn-sm" data-id="' +
			// item.id +
			// '" data-toggle="modal" data-target="#exampleModal">' +
			// '<i class="fa fa-fw" aria-hidden="true"></i>' +
			// "</button>" +
			'<button type="button" id="btn-remove" class="btn btn-danger btn-sm ml-1" data-id="' +
			item.id +
			'" data-status="' +
			item.status +
			'" data-toggle="tooltip" data-placement="top" title="Edit Status Siswa">' +
			'<i class="pe-7s-' +
			locked +
			'">' +
			"</i></button>" +
			"</td>" +
			"</tr>";
	});
	$("#table_view").html(trHTML);
}

$(document).on("click", "#btn-remove", function (event) {
    var id = $(this).attr('data-id');
    var link = url + 'api/exam/delete'
    Swal.fire({
        title:  "Hapus Soal",
        text: "Anda Setuju Untuk Menghapus Soal ?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Setuju',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.value) {
            Swal.fire(
                'Sukses Hapus Soal'
            ).then(
            
                $.ajax({
                    url: link,
                    type: 'post',
                    dataType: 'json',
                    data:{id:id},
                    success: function (response) {
                        setTimeout(location.reload.bind(location),3e3)
                    },
                    error: function (t) {
                        console.log(t);
                    }
                })

            )
        }
    });
});

// $(document).on("click", "#btn-details", function (event) {
//     $.ajax({
//         url: url + 'api/exam/show?id=' + $(this).attr('data-id'),
//         type: 'get',
//         dataType: 'json',
//         success: function (response) {
//             modal_detail(response.result)
//         },
//         error: function (t) {
//             console.log(t);
//         }
//     });
// });

// function modal_detail(response) {
//     // console.log(response.choice.B)
//     var photo = response.profilePhoto === 'http://localhost/learning/public/' ? 'http://localhost/learning/public/upload/profile/default.jpg' : response.profilePhoto;

//     $('#soal').text(response.question)
//     $('#email-view').text(response.email)
//     $('#identity-view').text(response.numberIdentity)
//     $('#fullname-view').text(response.fullname)
//     $('#years-view').text(response.schoolYear)
//     $('#bod-view').text(response.bornOfDate)
//     $('#gender-view').text(response.gender)
//     $('#religion-view').text(response.religion)
//     $('#address-view').text(response.address.address)
//     $('#city-view').text(response.address.city)
//     $('#state-view').text(response.address.state)
//     $('#zip-view').text(response.address.zip)
//     $('#phone-view').text(response.phone)
//     var drEvent = $(".dropify-view").dropify({ defaultFile: photo, messages: {
//         'replace': ''
//     } });
//     drEvent = drEvent.data('dropify');
//     drEvent.settings.defaultFile = photo;
//     drEvent.destroy();
//     drEvent.init();

// }