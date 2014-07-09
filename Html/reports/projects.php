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

		$query = 'SELECT id, name, comment FROM projects';

		$row_resource = $pdo->query($query);

		while ($row = $row_resource->fetchObject()) {
			$string .= '<tr>';
			$string .= '<td><a href="?id=' . $row->id . '">' . $row->name . '</a></td>';
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

	public function redirect(){
		global $pdo;

		if(isset($_GET['id'])){
			header('Location: ' . $_SERVER['PHP_SELF']);
			exit;
		}
	}
}

$report = new ProjectsReport();

include "/inc/reports.php";
?>