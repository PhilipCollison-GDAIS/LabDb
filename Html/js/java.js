
/* Initialize all datatables */
$(document).ready(function() {
	var table = $('.data-table').DataTable({
		// A complete list of options can be found at: http://www.datatables.net/reference/option/
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
		"autoWidth": false,
		// "border-bottom": false,
	});
});

/* Append the value of the first selected row to the href and redirect user to this location */
function redirectUser(element, url) {
	$(element).attr('href', function() {
		window.location.href = url + $(this).closest("div.table-n-buttons").find("tr.selected").attr("value");
	});
}

$(function() {
	$('.data-table tbody').on('click', 'tr', function() {

		// do not select empty rows
		if($(this).children('td.dataTables_empty').length){
			return;
		}

		$(this).toggleClass('selected');

		var div = $(this).closest('div.table-n-buttons');
		var selectedCount = div.find('.selected').length;

		/* Buttons with classes of "oneSelected" and "notNoneSelected" are
			disabled and enabled based on number of selected rows */
		if(selectedCount == 1){
			div.find('button.oneSelected').removeAttr('disabled'); //Enable
		} else {
			div.find('button.oneSelected').attr('disabled', 'disabled'); //Disable
		}

		if(selectedCount != 0){
			div.find('button.notNoneSelected').removeAttr('disabled'); //Enable
		} else {
			div.find('button.notNoneSelected').attr('disabled', 'disabled'); //Disable
		}

	});
});

$(function(){
	$('button.delete-button').each(function() {
		var name = $(this).closest("div.table-n-buttons").attr("name");
		$(this).attr("name", name);
		$(this).after('<div class="confirm_delete" name="' + name + '"><p>Are you sure you want delete the selected rows?</p></div>');
	});

	$("div.confirm_delete").dialog({
		autoOpen: false,
		draggable: false,
		modal: true,

		buttons: {
			"OK": function(){
				var modal = $(this);

				var name = $(this).attr("name");

				var values = new Array();
				$('.table-n-buttons[name="' + name + '"] .data-table tr.selected').each(function() {
					values.push($(this).attr("value"));
				});

				var data = {};

				var key = name + "-delete";

				data[key] = values;

				$.ajax({
					type: "POST",
					data: data,
					success: function(){
						var table = new $.fn.dataTable.Api('.table-n-buttons[name="' + name + '"] .data-table');
						table.rows(".selected").remove().draw();

						modal.dialog("close");
					}
				});
			},
			"Cancel": function() {
				$(this).dialog("close");
			}
		}
	});

	$("button.delete-button").click(function() {
		var name = $(this).attr("name");
		$("div.confirm_delete[name='" + name + "']").dialog("open");
	});
});
