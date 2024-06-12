// document.addEventListener("DOMContentLoaded", function () {
// 	var el;
// 	window.TomSelect &&
// 		new TomSelect((el = document.getElementById("select-users")), {
// 			copyClassesToDropdown: false,
// 			dropdownParent: "body",
// 			controlInput: "<input>",
// 			render: {
// 				item: function (data, escape) {
// 					if (data.customProperties) {
// 						return (
// 							'<div><span class="dropdown-item-indicator">' +
// 							data.customProperties +
// 							"</span>" +
// 							escape(data.text) +
// 							"</div>"
// 						);
// 					}
// 					return "<div>" + escape(data.text) + "</div>";
// 				},
// 				option: function (data, escape) {
// 					if (data.customProperties) {
// 						return (
// 							'<div><span class="dropdown-item-indicator">' +
// 							data.customProperties +
// 							"</span>" +
// 							escape(data.text) +
// 							"</div>"
// 						);
// 					}
// 					return "<div>" + escape(data.text) + "</div>";
// 				},
// 			},
// 		});
// });
var table;
$(document).ready(function () {
	// $(".datatabledengandiv").DataTable({
	// 	dom: "<'extra'>frtip",
	// });
	// $("div.extra").html($("#sisipkan").html()).insertAfter(".dataTables_filter");

	table = $("#tabelnya").DataTable({
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: base_url + "barang/get_data_barang",
			type: "POST",
		},
		columnDefs: [
			{
				targets: [0],
				orderable: false,
			},
		],
		pageLength: 50,
		dom: '<"pull-left"l><"pull-right"f>t<"bottom-left"i><"bottom-right"p>',
	});
	// $(".dataTables_filter").css("float", "right !important");
});
