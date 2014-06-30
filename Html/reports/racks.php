<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";

class RacksReport implements reportsInterface{
	public function getTitle(){
		return 'Racks';
	}

	public function getHeading(){
		return 'Racks';
	}

	public function getTableString(){
		global $pdo;

		$string = '<table class="table">';

		$string .= '<tr>';
		$string .= '<th>Name</th>';
		$string .= '<th>Old Name</th>';
		$string .= '<th>Room Number</th>';
		$string .= '<th>Floor Location</th>';
		$string .= '<th>Dimensions (W x H x D) </th>';
		$string .= '<th>Max Power</th>';
		$string .= '<th>Comments</th>';
		$string .= '</tr>';

		$query = 'SELECT name, old_name, room_number, floor_location, height_ru, width, depth, max_power, racks.comment 
					FROM racks, rooms, widths, depths
					WHERE racks.room_id = rooms.id
					AND racks.width_id = widths.id
					AND racks.depth_id = depths.id';

		$row_resource = $pdo->query($query);

		while ($row = $row_resource->fetchObject()) {
			$string .= '<tr>';
			$string .= '<td><a href="#">' . $row->name . '</a></td>';
			$string .= '<td>' . $row->old_name . '</td>';
			$string .= '<td>' . $row->room_number . '</td>';
			$string .= '<td>' . $row->floor_location . '</td>';
			$string .= '<td>' . $row->height_ru . ' x ' . $row->width . ' x ' . $row->depth . '</td>';
			$string .= '<td>' . $row->max_power . '</td>';
			$string .= '<td>' . $row->comment . '</td>';
			$string .= '<td><a href="#">Edit</a></td>';
			$string .= '</tr>';
		}

		$string .= '</table>';

		return $string;
	}

	public function getAddButton(){
		return '<a href="/forms/racks.php">Add Rack</a>';
	}
}

$report = new RacksReport();

include "/inc/reports.php";
?>