<?php
require_once "/inc/connect.php";

function queryEquipmentForVendor ($equipment_object) {
	global $pdo;

	$query_vendors = "SELECT * FROM vendors WHERE id=$equipment_object->vendor_id";

	$equipment_object = $pdo->query($query_vendors);
	$vendor_row = $equipment_object->fetchObject();

	return $vendor_row->vendor;
}

// TODO: rewrite
function queryEquipmentForLocation ($equipment_object) {
	// global $pdo;

	// $query_affiliation = "$equipment_object->affiliated";
	// $affiliation = $pdo->query($query_affiliation);

	// if($equipment_object->affiliated == 'E'){
	// 	$query_parent_equipment = "SELECT * FROM equipment WHERE id=$equipment_object->parent_equipment_id";

	// 	$parent_equipment_resource = $pdo->query($query_parent_equipment);
	// 	$parent_equipment_object = $parent_equipment_resource->fetchObject();

	// 	return get_equipment_location($parent_equipment_object);
	// }

	// $query_racks = "SELECT * FROM racks WHERE id=$equipment_object->parent_rack_id";

	// $rack_resource = $pdo->query($query_racks);
	// $rack_row = $rack_resource->fetchObject();

	// $room_query = "SELECT floor_location FROM rooms WHERE id=$rack_row->room_id";

	// $room_resource = $pdo->query($room_query);
	// $room_row = $room_resource->fetchObject();

	// return $room_row->floor_location;

	return "";
}

function tableStringForRooms(){
	global $pdo;

	$string = '<table class="table">';

	$string .= '<tr>';
	$string .= '<th>Room Number</th>';
	$string .= '<th>Comment</th>';
	$string .= '</tr>';

	$query = 'SELECT * FROM rooms';

	$row_resource = $pdo->query($query);

	while ($row = $row_resource->fetchObject()) {
		$string .= '<tr>';
		$string .= '<td>' . $row->room_number . '</td>';
		$string .= '<td>' . $row->comment . '</td>';
		$string .= '<td><a href="#">Edit</a></td>';
		$string .= '</tr>';
	}

	$string .= '</table>';

	return $string;
}

function tableStringForVendors(){
	global $pdo;

	$string = '<table class="table">';

	$string .= '<tr>';
	$string .= '<th>Vendor</th>';
	$string .= '<th>Comments</th>';
	$string .= '</tr>';

	$query = 'SELECT * FROM vendors';

	$row_resource = $pdo->query($query);

	while ($row = $row_resource->fetchObject()) {
		$string .= '<tr>';
		$string .= '<td><a href="#">' . $row->vendor . '</a></td>';
		$string .= '<td>' . $row->comment . '</td>';
		$string .= '<td><a href="#">Edit</a></td>';
		$string .= '</tr>';
	}

	$string .= '</table>';

	return $string;
}

function tableStringForRacks(){
	global $pdo;

	$string = '<table class="table">';

	$string .= '<tr>';
	$string .= '<th>Name</th>';
	$string .= '<th>Old Name</th>';
	$string .= '<th>Room ID</th>';
	$string .= '<th>Floor Location</th>';
	$string .= '<th>Height</th>';
	$string .= '<th>Width ID</th>';
	$string .= '<th>Depth ID</th>';
	$string .= '<th>Max Power</th>';
	$string .= '<th>Comments</th>';
	$string .= '</tr>';

	$query = 'SELECT * FROM racks';

	$row_resource = $pdo->query($query);

	while ($row = $row_resource->fetchObject()) {
		$string .= '<tr>';
		$string .= '<td><a href="#">' . $row->name . '</a></td>';
		$string .= '<td>' . $row->old_name . '</td>';
		$string .= '<td>' . $row->room_id . '</td>';
		$string .= '<td>' . $row->floor_location . '</td>';
		$string .= '<td>' . $row->height_ru . '</td>';
		$string .= '<td>' . $row->width_id . '</td>';
		$string .= '<td>' . $row->depth_id . '</td>';
		$string .= '<td>' . $row->max_power . '</td>';
		$string .= '<td>' . $row->comment . '</td>';
		$string .= '<td><a href="#">Edit</a></td>';
		$string .= '</tr>';
	}

	$string .= '</table>';

	return $string;
}

function tableStringForProjects(){
	global $pdo;

	$string = '<table class="table">';

	$string .= '<tr>';
	$string .= '<th>Project Name</th>';
	$string .= '<th>Comments</th>';
	$string .= '</tr>';

	$query = 'SELECT * FROM projects';

	$row_resource = $pdo->query($query);

	while ($row = $row_resource->fetchObject()) {
		$string .= '<tr>';
		$string .= '<td><a href="#">' . $row->name . '</a></td>';
		$string .= '<td>' . $row->comment . '</td>';
		$string .= '<td><a href="#">Edit</a></td>';
		$string .= '</tr>';
	}

	$string .= '</table>';

	return $string;
}

function tableStringForEquipment(){
	global $pdo;

	$string = '<table class="table">';

	$string .= '<tr>';
	$string .= '<th>Model</th>';
	$string .= '<th>Location</th>';
	$string .= '<th>Vendor</th>';
	$string .= '</tr>';

	$query = "SELECT * FROM equipment";

	$row_resource = $pdo->query($query);

	while ($row = $row_resource->fetchObject()) {
		$string .= '<tr>';
		$string .= '<td>' . $row->model . '</td>';
		$string .= '<td>' . queryEquipmentForLocation($row) . '</td>';
		$string .= '<td>' . queryEquipmentForVendor($row) . '</td>';
		$string .= '<td><a href="#">Edit</a></td>';
		$string .= '</tr>';
	}

	$string .= '</table>';

	return $string;
}
