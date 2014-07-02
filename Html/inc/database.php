<?php
require_once "/inc/connect.php";

function getWidthOptions($id){
	global $pdo;

	$string .= '<option></option>';

	$query = 'SELECT id, width FROM widths';

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

function getDepthOptions($id){
	global $pdo;

	$string .= '<option></option>';

	$query = 'SELECT id, depth FROM depths';

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

function getRoomOptions($id){
	global $pdo;

	$string .= '<option></option>';

	$query = 'SELECT id, room_number FROM rooms';

	$row_resource = $pdo->query($query);

	while ($row = $row_resource->fetchObject()) {
		$string .= '<option value="';
		$string .=  $row->id;
		$string .= '"';
		if(isset($id) && $id == $row->id){
			$string .= ' selected="selected"';
		}
		$string .= '>';
		$string .= $row->room_number;
		$string .= '</option>';
	}

	return $string;
}

function getRackOptions($id){
	global $pdo;

	$string .= '<option></option>';

	$query = 'SELECT id, name FROM racks';

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

function isAlphaNumeric($x, $length) {
	return !empty($x) && (!isset($length) || strlen($x) > $length) && ctype_alnum($x);
}