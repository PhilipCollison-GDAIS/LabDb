
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

	$('.data-table tbody').on('click', 'tr', function() {
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

/* Append to the href the value of the first selceted row. */
function addURL(element) {
	$(element).attr('href', function() {
		return this.href + $(this).closest("div.table-n-buttons").find("tr.selected").attr("value");
	});
}

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
			"OK": function() {
				var name = $(this).attr("name");

				var values = new Array();
				$('div.table-n-buttons[name="' + name + '"] .data-table tr.selected').each(function (index) {
					values.push( $(this).attr("value") );
				})

				var data = {};

				var key = name + "-delete";

				data[key] = values;

				$.ajax({
					type: "POST",
					data: data,
					success: function(html){
						location.reload();
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
