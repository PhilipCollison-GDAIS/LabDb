<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";

class VendorsReport implements reportsInterface{
	public function redirect(){
		global $pdo;

		if(isset($_GET['edit_id'])){
			header('Location: ' . $_SERVER['PHP_SELF']);
			exit;
		}
	}

	public function getTitle(){
		return 'Vendors';
	}

	public function getHeading(){
		return 'Vendors';
	}

	public function getTableString(){
		global $pdo;

		$string = '<table class="table data-table">';

		$string .= '<thead>';
		$string .= '<tr>';
		$string .= '<th>Vendor</th>';
		$string .= '<th>Comments</th>';
		$string .= '<th><a href="/forms/vendors.php">Add Vendor</a></th>';
		$string .= '</tr>';
		$string .= '</thead>';

		$query = 'SELECT id, vendor, comment FROM vendors ORDER BY vendor';

		$row_resource = $pdo->query($query);

		$string .= '<tbody>';
		while ($row = $row_resource->fetchObject()) {
			$string .= '<tr>';
			$string .= '<td><a href="?id=' . htmlspecialchars($row->id) . '">' . htmlspecialchars($row->vendor) . '</a></td>';
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

$report = new VendorsReport();

include "/inc/reports.php";
?>