<?php
require_once "/inc/connect.php";

function getWidthOptions($id = NULL){
	global $pdo;

	$string = '<option></option>';

	$query = 'SELECT id, width FROM widths ORDER BY width';

	$row_resource = $pdo->query($query);

	while ($row = $row_resource->fetchObject()) {
		$string .= '<option value="';
		$string .=  $row->id;
		$string .= '"';
		if(isset($id) && $id == $row->id){
			$string .= ' selected="selected"';
		}
		$string .= '>';
		$string .= $row->width;
		$string .= '</option>';
	}

	return $string;
}

function getDepthOptions($id = NULL){
	global $pdo;

	$string = '<option></option>';

	$query = 'SELECT id, depth FROM depths ORDER BY depth';

	$row_resource = $pdo->query($query);

	while ($row = $row_resource->fetchObject()) {
		$string .= '<option value="';
		$string .=  $row->id;
		$string .= '"';
		if(isset($id) && $id == $row->id){
			$string .= ' selected="selected"';
		}
		$string .= '>';
		$string .= $row->depth;
		$string .= '</option>';
	}

	return $string;
}

function getRoomOptions($id = NULL){
	global $pdo;

	$string = '<option></option>';

	$query = 'SELECT id, room_number, building_name
			  FROM rooms
			  ORDER BY building_name, room_number';

	$row_resource = $pdo->query($query);

	while ($row = $row_resource->fetchObject()) {
		$string .= '<option value="' . $row->id . '"';
		if(isset($id) && $id == $row->id){
			$string .= ' selected="selected"';
		}
		$string .= '>';
		$string .= $row->room_number . ' ' . $row->building_name;
		$string .= '</option>';
	}

	return $string;
}

function getRackOptions($id = NULL){
	global $pdo;

	$string = '<option></option>';

	$query = 'SELECT racks.id AS rack_id, racks.name AS rack_name, rooms.id AS room_id, room_number, building_name
			  FROM racks, rooms
			  WHERE rooms.id = racks.room_id
			  ORDER BY room_id, rack_name';

	$row_resource = $pdo->query($query);

	$rack_ids = array();
	$rack_names = array();
	$room_info = array();

	foreach($row_resource->fetchAll() as $row) {
		$rack_ids[$row['room_id']][] = $row['rack_id'];
		$rack_names[$row['room_id']][] = $row['rack_name'];
		$room_info[$row['room_id']]['building_name'] = $row['building_name'];
		$room_info[$row['room_id']]['room_number'] = $row['room_number'];
	}

	foreach ($room_info as $key => $info) {
		$string .= '<optgroup label="' . $info['room_number'] . ', ' . $info['building_name'] . '">';
		for ($i = 0; $i < count($rack_ids[$key]); $i = $i + 1) {
			$string .= '<option value="' . $rack_ids[$key][$i] . '"';
			if (isset($id) && $id == $rack_ids[$key][$i]) {
				$string .= ' selected="selected"';
			}
			$string .= '>';
			$string .= $rack_names[$key][$i];
			$string .= '</option>';
		}
		$string .= '</optgroup>';
	}

	return $string;
}

function getVendorOptions($id = NULL){
	global $pdo;

	$string = '<option></option>';

	$query = 'SELECT id, vendor FROM vendors';

	$row_resource = $pdo->query($query);

	while ($row = $row_resource->fetchObject()) {
		$string .= '<option value="';
		$string .=  $row->id;
		$string .= '"';
		if(isset($id) && $id == $row->id){
			$string .= ' selected="selected"';
		}
		$string .= '>';
		$string .= $row->vendor;
		$string .= '</option>';
	}

	return $string;
}

function getConnectorOptions($id = NULL){
	global $pdo;

	$string = '<option></option>';

	$query = 'SELECT id, connector_type, affiliated FROM connector_types';

	$row_resource = $pdo->query($query);

	$info = array();

	foreach($row_resource->fetchAll() as $row) {
		$info[$row['affiliated']][] = array('id' => $row['id'], 'type' => $row['connector_type']);
	}

	foreach ($info as $affiliated => $data) {
		if ($affiliated === "E")
			$affiliated = "Electrical";

		if ($affiliated === "O")
			$affiliated = "Optical";

		$string .= '<optgroup label="' . $affiliated . '">';
		for ($i = 0; $i < count($data); $i = $i + 1) {
			$string .= '<option value="' . $data[$i]['id'] . '"';
			if (isset($id) && $id === $data[$i]['id']){
				$string .= ' selected="selected"';
			}
			$string .= '>';
			$string .= $data[$i]['type'];
			$string .= '</option>';
		}
		$string .= '</optgroup>';
	}

	return $string;

	while ($row = $row_resource->fetchObject()) {
		$string .= '<option value="';
		$string .=  $row->id;
		$string .= '"';
		if(isset($id) && $id == $row->id){
			$string .= ' selected="selected"';
		}
		$string .= '>';
		$string .= $row->connector_type;
		$string .= '</option>';
	}

	return $string;
}

function getProjectOptions($id = NULL){
	global $pdo;

	$string = '<option></option>';

	$query = 'SELECT id, name FROM projects';

	$row_resource = $pdo->query($query);

	while ($row = $row_resource->fetchObject()) {
		$string .= '<option value="';
		$string .=  $row->id;
		$string .= '"';
		if(isset($id) && $id == $row->id){
			$string .= ' selected="selected"';
		}
		$string .= '>';
		$string .= $row->name;
		$string .= '</option>';
	}

	return $string;
}

function isNaturalNumber($x) {
	return !empty($x) && is_numeric($x) && $x > 0 && $x == round($x);
}

function isAlphaNumeric($x, $length = -1) {
	return !empty($x) && ($length == -1 || strlen($x) <= $length) && ctype_alnum($x);
}

function isInteger($input){
	return (is_numeric($x) ? intval($x) == $x : false);
}
