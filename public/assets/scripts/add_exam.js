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
			$('select[name="kategori"]').html(trHTML);
			loadSubCategories(1);
		},
		error: function (t) {
			console.log(t);
		},
	});
}

$("select[name=kategori]").change(function () {
	var id = $(this).children(":selected").attr("id");
	loadSubCategories(id);
});

function loadSubCategories(id) {
	$.ajax({
		url: url + "/menu/subcategories/" + id,
		type: "get",
		dataType: "json",
		success: function (response) {
			var trHTML = "";
			$.each(response.message, function (i, item) {
				trHTML +=
					'<option class="caps" value="' +
					item.idSubCategories +
					'">' +
					item.subname +
					"</option>";
			});
			$('select[name="subkategori"]').html(trHTML);
		},
		error: function (t) {
			console.log(t);
		},
	});
}

$("select[name=type]").change(function () {
	var id = $(this).children(":selected").attr("value");
    if (id==3) {
        $("[id=content-category]").show();
    } else {
        $("[id=content-category]").hide();
    }
});
