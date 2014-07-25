$(document).ready(function() {
	var table = $('.data-table').DataTable({
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

	$('.data-table').on('click', 'tr', function() {
		$(this).toggleClass('selected');

		// disable and enable buttons based on number of selected rows
		var selected = table.rows('.selected').data().length;
		if(selected == 1){
			$('.oneSelected').removeAttr('disabled'); //Enable
		} else {
			$('.oneSelected').attr('disabled', 'disabled'); //Disable
		}
		if(selected != 0){
			$('.notNoneSelected').removeAttr('disabled'); //Enable
		} else {
			$('.notNoneSelected').attr('disabled', 'disabled'); //Disable
		}
	});
});

$(function(){
	$(".DropdownInitiallyBlank").prop("selectedIndex", -1);
});
