<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";

class RoomsReport implements reportsInterface{
	public function getTitle(){
		return 'Rooms';
	}

	public function getHeading(){
		return 'Rooms';
	}

	public function getTableString(){
		global $pdo;

		$string = '<table class="table">';

		$string .= '<tr>';
		$string .= '<th>Room Number</th>';
		$string .= '<th>Comment</th>';
		$string .= '</tr>';

		$query = 'SELECT room_number, comment FROM rooms';

		$row_resource = $pdo->query($query);

		while ($row = $row_resource->fetchObject()) {
			$string .= '<tr>';
			$string .= '<td><a href="#">' . $row->room_number . '</td>';
			$string .= '<td>' . $row->comment . '</td>';
			$string .= '<td><a href="#">Edit</a></td>';
			$string .= '</tr>';
		}

		$string .= '</table>';

		return $string;
	}

	public function getIdString($id){
		return $this->getTableString();
	}

	public function getAddButton(){
		return '<a href="/forms/rooms.php">Add Room</a>';
	}
}

$report = new RoomsReport();

include "/inc/reports.php";
?>