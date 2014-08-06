<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";

class RoomsReport implements reportsInterface{
	public function redirect(){
		global $pdo;

		if(isset($_GET['id'])){
			header('Location: ' . $_SERVER['PHP_SELF']);
			exit;
		}
	}

	public function getTitle(){
		return 'Rooms';
	}

	public function getHeading(){
		return 'Rooms';
	}

	public function getTableString(){
		global $pdo;

		$string = '<table class="table data-table">';

		$string .= '<thead>';
		$string .= '<tr>';
		$string .= '<th>Room Number</th>';
		$string .= '<th>Building Name</th>';
		$string .= '<th>Comment</th>';
		$string .= '<th><a href="/forms/rooms.php">Add Room</a></th>';
		$string .= '</tr>';
		$string .= '</thead>';

		$query = 'SELECT id, building_name, room_number, comment FROM rooms ORDER BY building_name, room_number';

		$row_resource = $pdo->query($query);

		$string .= '<tbody>';
		while ($row = $row_resource->fetchObject()) {
			$string .= '<tr>';
			$string .= '<td><a href="?id=' . htmlspecialchars($row->id) . '">' . htmlspecialchars($row->room_number) . '</td>';
			$string .= '<td>' . htmlspecialchars($row->building_name) . '</td>';
			$string .= '<td>' . htmlspecialchars($row->comment) . '</td>';
			$string .= '<td><a href="#">Edit</a></td>';
			$string .= '</tr>';
		}
		$string .= '</tbody>';

		$string .= '</table>';

		return $string;
	}

	public function getIdString($id){
		echo '<script>window.location = "' . strtok($_SERVER['REQUEST_URI'], '?') . '";</script>';
		exit;
	}

}

$report = new RoomsReport();

include "/inc/reports.php";
?>