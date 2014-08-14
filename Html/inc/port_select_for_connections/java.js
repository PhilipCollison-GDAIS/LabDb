
$(function() {
	$('.port-table').on('click', 'tr', function() {
		// do not select head or a row signifying table is empty
		if($(this).parent('thead').length || $(this).hasClass('no-data')){
			return;
		}

		$(this).closest('tbody').find('.selected').removeClass('selected');

		$(this).toggleClass('selected');

		enableConnection();
	});
});

function fetchEquipment(element){
	var rack_id = $(element).val();
	if (rack_id === "") {
		hideEquipment(element);
		return;
	}

	$.ajax({
		type: "POST",
		data: {rack_id: rack_id},
		url: "/inc/port_select_for_connections/fetch_equipment.php",
		beforeSend: function(){
			hideEquipment(element);
			$(element).closest('.single-element').find('.equipment select').html('<option></option><option disabled="disabled">...</option>');
			showEquipment(element);
		},
		success: function(html){
			$(element).closest('.single-element').find('.equipment select').html(html);
		}
	});
}

function fetchPorts(element){
	var equipment_id = $(element).val();
	if (equipment_id === "") {
		hidePorts(element);
		return;
	}

	$(element).closest('.single-element').find('.ports').show();

	$.ajax({
		type: "POST",
		data: {equipment_id: equipment_id},
		url: "/inc/port_select_for_connections/fetch_ports.php",
		beforeSend: function(){
			hidePorts(element);
		},
		success: function(html){
			$(element).closest('.single-element').find('.ports').html(html);
			showPorts(element);
		}
	});
}

function hideEquipment(element) {
	hidePorts(element);
	$(element).closest('.single-element').find('.equipment').hide();
}

function showEquipment(element) {
	$(element).closest('.single-element').find('.equipment').show();
}

function hidePorts(element) {
	disableConnection();
	$(element).closest('.single-element').find('.ports').hide();
}

function showPorts(element) {
	$(element).closest('.single-element').find('.ports').show();
}

function enableConnection(){
	if (isValidConnection()) {
		$('.create-connection-button').prop("disabled", false);
	}
}

function disableConnection(){
	$('.create-connection-button').prop("disabled", true);
}

function isValidConnection(){
	var selectedRows = $('.port-table tr.selected');

	if (selectedRows.length !== 2) {
		return false;
	}

	return true;
}

function createConnection() {
	if (isValidConnection()) {
		var selectedRows = $('.port-table tr.selected');

		$.ajax({
			type: "POST",
			data: {port_id_1: $(selectedRows[0]).attr('value'), port_id_2: $(selectedRows[1]).attr('value')},
			beforeSend: function(){
			},
			success: function(html){
				window.location = "/reports/connections.php?id=" + html;
			}
		});
	}
}