var url = $("body").attr("data-url");

$(document).ready(function () {
	$("[id=content-category]").hide();

	loadType();

	loadCategories();

	$("#smartwizard").smartWizard({
		selected: 0,
		theme: "progress",
		autoAdjustHeight: true,
		transition: {
			animation: "slide-swing", // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
			speed: "800", // Transion animation speed
		},
		showStepURLhash: true,
		justified: true,
		keyboardSettings: {
			keyNavigation: false,
		},
	});

	$("#smartwizard").on("showStep", function (
		e,
		anchorObject,
		stepNumber,
		stepDirection
	) {
		stepNumber == 0 ? $(".sw-btn-prev").hide() : $(".sw-btn-prev").show();
		if ($("button.sw-btn-next").hasClass("disabled")) {
			$(".sw-btn-next").hide();
			$(".sw-btn-save").show(); // show the button extra only in the last page
		} else {
			$(".sw-btn-next").show();
			$(".sw-btn-save").hide();
		}
	});

	$(function () {
		var formula = "";
		operation = function (math) {
			formula += math;
			$("#target").get(0).innerHTML = "$" + formula + "$";
			var math = document.getElementById("target");
			MathJax.Hub.Queue(["Typeset", MathJax.Hub, math]);
		};
	});

	var drEvent = $(".dropify").dropify({
		messages: {
			default: "Upload gambar disini ",
			error: "Terjadi kesalahan upload",
		},
		error: {
			fileSize: "Ukuran file terlalu besar, maksimal ({{ value }}).",
			fileExtension: "Format file tidak diijinkan, untuk format ({{ value }}).",
		},
		wrap: '<div class="dropify-wrapper"></div>',
		loader: '<div class="dropify-loader"></div>',
	});

	drEvent = drEvent.data("dropify");
	drEvent.resetPreview();
	drEvent.clearElement();
	drEvent.data(300);
	drEvent.destroy();
	drEvent.init();

	var opt = {};
	$("#title > option").each(function () {
		if (opt[$(this).text()]) {
			$(this).remove();
		}
	});
});

$(document).on("blur", "textarea[name='question']", function () {
	console.log("btn_click");
	var textarea = $('textarea[name="question"]');
	var myBookId = textarea.val();
	console.log(myBookId);
	var id = textarea.attr("name");
	$(".value_input").text(myBookId);
	$(".value_input").attr("id", id);
});
$(document).on("focusout", "input[name=A]", function () {
	console.log("btn_click");
	var input = $("input[name=A]");
	var myBookId = input.val();
	var id = input.attr("name");
	console.log(id);
	$(".value_input").text(myBookId);
	$(".value_input").attr("id", id);
});
$(document).on("focusout", "input[name=B]", function () {
	console.log("btn_click");
	var input = $("input[name=B]");
	var myBookId = input.val();
	var id = input.attr("name");
	console.log(id);
	$(".value_input").text(myBookId);
	$(".value_input").attr("id", id);
});
$(document).on("focusout", "input[name=C]", function () {
	console.log("btn_click");
	var input = $("input[name=C]");
	var myBookId = input.val();
	var id = input.attr("name");
	console.log(id);
	$(".value_input").text(myBookId);
	$(".value_input").attr("id", id);
});
$(document).on("focusout", "input[name=D]", function () {
	console.log("btn_click");
	var input = $("input[name=D]");
	var myBookId = input.val();
	var id = input.attr("name");
	console.log(id);
	$(".value_input").text(myBookId);
	$(".value_input").attr("id", id);
});

function loadType() {
	$.ajax({
		url: url + "/menu/type/",
		type: "get",
		dataType: "json",
		success: function (response) {
			var trHTML = "";
			$.each(response.message, function (i, item) {
				trHTML +=
					'<option class="caps" value="' +
					item.idType +
					'">' +
					item.typeName +
					"</option>";
			});
			$('select[name="type"]').html(trHTML);
		},
		error: function (t) {
			console.log(t);
		},
	});
}

function loadCategories() {
	$.ajax({
		url: url + "/menu/categories/",
		type: "get",
		dataType: "json",
		success: function (response) {
			var trHTML = "";
			$.each(response.message, function (i, item) {
				trHTML +=
					'<option class="caps" value="' +
					item.categoryname +
					'" id="' +
					item.idCategory +
					'">' +
					item.categoryname +
					"</option>";
			});
			$('select[id="kategori"]').html(trHTML);
		},
		error: function (t) {
			console.log(t);
		},
	});
}

function loadTitleExam(kelas, type, level) {
	$.ajax({
		url: url + "/menu/title",
		type: "post",
		dataType: "json",
		data: { class: kelas, type: type, level: level },
		success: function (response) {
			console.log(response);
			var trHTML = "";
			$.each(response.result, function (i, item) {
				trHTML +=
					'<option class="caps" id="' +
					'" value="' +
					item.title +
					'">' +
					item.title +
					"</option>";
			});
			trHTML += '<option value="new">-- Tambahkan Judul Ujian --</option>';
			$('select[id="title"]').html(trHTML);
		},
		error: function (t) {
			trHTML =
				'<option selected="true" disabled>-- Pilih Judul Ujian --</option>' +
				'<option value="new"> Tambahkan Judul Ujian </option>';
			$('select[id="title"]').html(trHTML);
		},
	});
}

$("select[id=title]").change(function () {
	if ($(this).children("option:selected").attr("value") == "new") {
		add_newTitle();
	}
});

function add_newTitle() {
	var newThing = window.prompt("Masukkan nama judul baru:");
	if (newThing == null) {
		return;
	}
	trHTML = '<option value="' + newThing + '">' + newThing + "</option>";
	$(trHTML).insertBefore($("option[value=new]"));
	return;
}

$(document).on("change", "select:not(#title, #kategori)", function (e) {
	var type = $('select[name="type"]').children("option:selected").attr("value");
	var kelas = $('select[name="kelas"]')
		.children("option:selected")
		.attr("value");
	var level = $('select[name="level"]')
		.children("option:selected")
		.attr("value");
	loadTitleExam(kelas, type, level);
});

$("select[name=type]").change(function () {
	var id = $(this).children(":selected").attr("value");
	if (id != 1) {
		$("[id=content-category]").show();
		$("#kategori").attr("name", "kategori");
		$("#title").attr("name", "title");
	} else {
		$("[id=content-category]").hide();
		$("#kategori").removeAttr("name", "kategori");
		$("#title").removeAttr("name", "title");
	}
});

$(document).on("submit", "#submit-exam", function (e) {
	e.preventDefault();
	var formData = new FormData(this);
	$.ajax({
		url: url + "api/exam/add",
		type: "POST",
		data: formData,
		contentType: !1,
		cache: !1,
		processData: !1,
		success: function (t) {
			Swal.fire({
				title: "Berhasil Ditambahkan",
				text: t.message,
				type: "success",
				showCancelButton: true,
				confirmButtonColor: "#30c7ec",
				cancelButtonColor: "#6c757d",
				confirmButtonText: "Tambahkan Lagi Soal",
				cancelButtonText: "Selesai",
			}).then((result) => {
				console.log(result)
				if (result.value) {
					setTimeout((window.location = url + "/dashboard/add_exam", 100));
				} else {
					var type = $('select[name=type]').children("option:selected").attr("value");
					if (type == "1") {
						var link = url + "dashboard/pretestexam";
					} else if (type == "2") {
						var link = url + "dashboard/finalexam";
					} else {
						var link = url + "dashboard/dailyexam";
					}
					setTimeout((window.location = link), 100);
				}
			});
		},
		error: function (t) {
			let a = t.responseJSON;
			if ((console.log(t), 403 != t.status)) {
				var e = $(
					'<div class="toast toast-warning" aria-live="assertive"><button type="button" class="toast-close-button" role="button" onclick="hideNotification()">×</button><div class="toast-title">Peringatan</div><div class="toast-message">' +
						a.message +
						"</div></div>"
				);
				$("#toast-container").append(e),
					$("#toast-container").slideDown().fadeIn(),
					!0;
				setTimeout(function () {
					$("#toast-container").fadeOut(2500, function () {
						location.reload(true);
					});
				}, 3000);
			}
			Object.entries(a.message).forEach(([t, a]) => {
				var e = $(
					'<div class="toast toast-warning" aria-live="assertive"><button type="button" class="toast-close-button" role="button">×</button><div class="toast-title">Peringatan</div><div class="toast-message">' +
						`${a}` +
						"</div></div>"
				);
				$("#toast-container").append(e),
					$("#toast-container").slideDown().fadeIn(),
					!0;
				setTimeout(function () {
					$("#toast-container").fadeOut(2500, function () {
						location.reload(true);
					});
				}, 3000);
			});
		},
	});
});

$(".toast-close-button").change(function () {
	$("#toast-container").fadeOut(100), $(".toast").remove();
});
