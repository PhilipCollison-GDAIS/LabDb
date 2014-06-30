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

