<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";

class ConnectionsReports implements reportsInterface{
	public function getTitle(){
		return 'Connections';
	}

	public function getHeading(){
		return 'Connections';
	}

	public function getTableString(){
		global $pdo;

		$string = '<table class="table data-table">';

		$string .= '<thead>';
		$string .= '<tr>';
		$string .= '<th>Connection Type</th>';
		$string .= '<th>Location</th>';
		$string .= '<th>Name</th>';
		$string .= '<th>Rack</th>';
		$string .= '<th>Elevation</th>';
		$string .= '<th>Name</th>';
		$string .= '<th>Rack</th>';
		$string .= '<th>Elevation</th>';
		$string .= '<th><a href="/forms/connections.php">Add Connection</a></th>';
		$string .= '</tr>';
		$string .= '</thead>';


		// TODO: Create, execute and display query for connection information
		// $query = 'SELECT id, name, comment FROM connections';

		// $row_resource = $pdo->query($query);

		// while ($row = $row_resource->fetchObject()) {
		// 	$string .= '<tr>';
		// 	$string .= '<td><a href="?id=' . $row->id . '">' . $row->name . '</a></td>';
		// 	$string .= '<td>' . $row->comment . '</td>';
		// 	$string .= '<td><a href="#">Edit</a></td>';
		// 	$string .= '</tr>';
		// }

		// TODO: remove this text row
		$string .= '<tr>';
		$string .= '<td>' . "optical" . '</td>';
		$string .= '<td>' . "building" . '</td>';
		$string .= '<td style="border-left:1px solid black;">' . "P-01" . '</td>';
		$string .= '<td>' . "R-01" . '</td>';
		$string .= '<td>' . "3" . '</td>';
		$string .= '<td style="border-left:1px solid black;">' . "P-02" . '</td>';
		$string .= '<td>' . "R-02" . '</td>';
		$string .= '<td>' . "3" . '</td>';
		$string .= '<td style="border-left:1px solid black;"><a href="#">Edit</a></td>';
		$string .= '</tr>';

		$string .= '</table>';

		return $string;
	}

	public function getIdString($id){
		return $this->getTableString();
	}

	public function redirect(){
		global $pdo;

		if(isset($_GET['id'])){
			header('Location: ' . $_SERVER['PHP_SELF']);
			exit;
		}
	}
}

$report = new ConnectionsReports();

include "/inc/reports.php";
?>