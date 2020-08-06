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
		trHTML +=
			"<tr>" +
			'<td class="text-center text-muted" >' +
			item.id +
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
			item.status +
			"</div>" +
			"</td>" +
			'<td class="text-center">' +
			'<button type="button" id="btn-details" class="btn btn-primary btn-sm" data-field="' +
			item.id +
			'" data-toggle="modal" data-target=".bd-example-modal-lg" data-toggle="tooltip" data-placement="top" title="Lihat Detail Siswa">' +
			'<i class="pe-7s-info">' +
			"</i></button>" +
			'<a type="button" id="btn-edit" class="btn btn-success btn-sm ml-1" data-field="' +
			item.id +
			'" data-toggle="modal" data-target=".bd-edit-modal-lg" data-toggle="tooltip" data-placement="top" title="Edit Siswa">' +
			'<i class="pe-7s-pen text-light">' +
			"</i></a>" +
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
	if (role == "guru") {
		$("[id=btn-remove]").remove();
		$("[id=btn-edit]").remove();
	}
}
