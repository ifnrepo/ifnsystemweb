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
	$(".datatabledengandiv").DataTable({
		dom: "<'extra'>frtip",
	});
	$("div.extra").html($("#sisipkan").html()).insertAfter(".dataTables_filter");
	$(".dataTables_filter").css("float", "right");
});
