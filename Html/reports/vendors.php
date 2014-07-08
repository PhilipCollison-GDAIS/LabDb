<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";

class VendorsReport implements reportsInterface{
	public function getTitle(){
		return 'Vendors';
	}

	public function getHeading(){
		return 'Vendors';
	}

	public function getTableString(){
		global $pdo;

		$string = '<table class="table">';

		$string .= '<tr>';
		$string .= '<th>Vendor</th>';
		$string .= '<th>Comments</th>';
		$string .= '<th><a href="/forms/vendors.php">Add Vendor</a></th>';
		$string .= '</tr>';

		$query = 'SELECT vendor, comment FROM vendors';

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

	public function getIdString($id){
		return $this->getTableString();
	}
}

$report = new VendorsReport();

include "/inc/reports.php";
?>