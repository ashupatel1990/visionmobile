$(document).ready(function() {
	// $("#tickets-table").DataTable({
		// pageLength : 5,
		// language:{
		// 	paginate:{
		// 		previous:"<i class='mdi mdi-chevron-left'>",
		// 		next:"<i class='mdi mdi-chevron-right'>"
		// 	}
		// },
		// drawCallback:function(){
		// 	$(".dataTables_paginate > .pagination").addClass("pagination-rounded")
		// }
	// });
	$("#invoice-table, #customers-list").DataTable({
		pageLength : 10
	});
});