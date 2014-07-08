<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";

class ProjectsReport implements reportsInterface{
	public function getTitle(){
		return 'Projects';
	}

	public function getHeading(){
		return 'Projects';
	}

	public function getTableString(){
		global $pdo;

		$string = '<table class="table">';

		$string .= '<tr>';
		$string .= '<th>Project Name</th>';
		$string .= '<th>Comments</th>';
		$string .= '<th><a href="/forms/projects.php">Add Project</a></th>';
		$string .= '</tr>';

		$query = 'SELECT name, comment FROM projects';

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

	public function getIdString($id){
		return $this->getTableString();
	}
}

$report = new ProjectsReport();

include "/inc/reports.php";
?>