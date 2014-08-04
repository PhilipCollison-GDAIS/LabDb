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

		$string = '<table class="table data-table">';

		$string .= '<thead>';
		$string .= '<tr>';
		$string .= '<th>Project Name</th>';
		$string .= '<th>Connections</th>';
		$string .= '<th>Equipment</th>';
		$string .= '<th>Comments</th>';
		$string .= '</tr>';
		$string .= '</thead>';

		$query = 'SELECT id AS unique_project_id_name, name, comment,
					(SELECT COUNT(*) FROM project_connections WHERE project_connections.project_id = unique_project_id_name) AS conn_count,
					(SELECT COUNT(*) FROM project_equipment WHERE project_equipment.project_id = unique_project_id_name) AS equip_count
				  FROM projects';

		$row_resource = $pdo->query($query);

		while ($row = $row_resource->fetchObject()) {
			$string .= '<tr>';
			$string .= '<td><a href="?id=' .  htmlspecialchars($row->id) . '">' .  htmlspecialchars($row->name) . '</a></td>';
			$string .= '<td>' .  htmlspecialchars($row->conn_count) . '</td>';
			$string .= '<td>' .  htmlspecialchars($row->equip_count) . '</td>';
			$string .= '<td>' .  htmlspecialchars($row->comment) . '</td>';
			$string .= '</tr>';
		}

		$string .= '</table>';

		$string .= '<br>';

		$string .= '<a href="/forms/projects.php"><button type="button" class="btn btn-default btn-lg">Add</button></a>';

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