
$(document).ready(function() {
	$('.data-table').dataTable( {
		 // A complete list of all optins can be found at: http://www.datatables.net/reference/option/
		"scrollY": 300,
		"scrollCollapse": true,
		"scrollX": true,
		"paging": false,
		"ordering": true,
		"searching": true,
		"lengthMenu": [-1], // disable pagination
		"order": [], // No initial ordering
		renderer: "bootstrap",
		"info": false,
		// "border-bottom": false,
	});
});

$(function(){
	$(".DropdownInitiallyBlank").prop("selectedIndex", -1);
});
