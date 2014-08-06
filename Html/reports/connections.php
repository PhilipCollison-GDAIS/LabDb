<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";
require_once "/delete/connections.php";

class ConnectionsReports implements reportsInterface{
	public function getTitle(){
		return 'Connections';
	}

	public function getHeading(){
		return 'Connections';
	}

	public function getTableString(){
		global $pdo;

		$string = '<div class="table-n-buttons" name="main-table-for-connections">';

		$string .= '<table class="table data-table">';

		$string .= '<thead>';
		$string .= '<tr>';
		$string .= '<th>Connector Type</th>';
		$string .= '<th>Location</th>';
		$string .= '<th>Project</th>';
		$string .= '<th>Rack</th>';
		$string .= '<th>Elevation</th>';
		$string .= '<th>Port Type</th>';
		$string .= '<th>Name</th>';
		$string .= '<th>Rack</th>';
		$string .= '<th>Elevation</th>';
		$string .= '<th>Port Type</th>';
		$string .= '<th>Name</th>';
		$string .= '</tr>';
		$string .= '</thead>';

		// Query to retrieve elevation and rack of port
		$port_location_stmt = $pdo->prepare('CALL elevation_and_rack_id_for_port(:port_id)');
		$port_location_stmt->bindParam(':port_id', $port_id);

		// Query to retrieve port name and type
		$port_info_stmt = $pdo->prepare('SELECT name, connector_types.affiliated, connector_types.connector_type
										 FROM ports, connector_types
										 WHERE ports.connector_type_id = connector_types.id AND ports.id = :port_id');
		$port_info_stmt->bindParam(':port_id', $port_id);

		// Query to retrieve rack name
		$rack_info_stmt = $pdo->prepare('SELECT racks.name, rooms.room_number, rooms.building_name
										 FROM rooms, racks
										 WHERE rooms.id = racks.room_id AND racks.id = :rack_id');
		$rack_info_stmt->bindParam(':rack_id', $rack_id);

		// Query for project information
		$project_info_stmt = $pdo->prepare('SELECT projects.id AS project_id, projects.name AS project_name
									 FROM connections, project_connections, projects
									 WHERE project_connections.connection_id = :connection_id AND project_connections.project_id = projects.id');
		$project_info_stmt->bindParam(':connection_id', $connection_id);

		// Iterate through every connection
		$row_resource = $pdo->query('SELECT id, port_id_1, port_id_2, comment FROM connections');
		while ($row = $row_resource->fetchObject()) {

			$is_first = true;

			// For each port in the connection
			foreach (array($row->port_id_1, $row->port_id_2) as $port_id) {
				// Retrieve port info
				$port_info_stmt->execute();
				$port_info = $port_info_stmt->fetchObject();

				// Retrieve elevation and rack id
				$port_location_stmt->execute();
				$rack_id_and_elevation = $port_location_stmt->fetchObject();
				$port_location_stmt->closeCursor();

				// Retrieve rack info
				$rack_id = $rack_id_and_elevation->rack_id;
				$rack_info_stmt->execute();
				$rack_info = $rack_info_stmt->fetchObject();

				// Display first two columns
				if ($is_first) {
					$is_first = false;
					$string .= '<tbody>';
					$string .= '<tr value="' . htmlspecialchars($row->id) . '">';
					$string .= '<td>';
					$string .=  htmlspecialchars($port_info->affiliated) === "E" ? 'Electrical' : 'Optical';
					$string .= '</td>';
					$string .= '<td>' . htmlspecialchars($rack_info->room_number) . " " .   htmlspecialchars($rack_info->building_name) . '</td>';

					//Retrieve project information
					$connection_id = $row->id;
					$project_info_stmt->execute();
					$project_info = $project_info_stmt->fetchObject();
					$string .= '<td>';
					$string .=  $project_info ? '<a href="/reports/projects.php?id=' . htmlspecialchars($project_info->project_id) . '">' . htmlspecialchars($project_info->project_name) . '</a>' : "";
					$string .= '</td>';
				}

				// Display information for current port
				$string .= '<td style="border-left:1px solid black;">' . htmlspecialchars($rack_info->name) . '</td>';
				$string .= '<td>' . htmlspecialchars($rack_id_and_elevation->elevation) . '</td>';
				$string .= '<td>' . htmlspecialchars($port_info->connector_type) . '</td>';
				$string .= '<td>' . htmlspecialchars($port_info->name) . '</td>';
			}

			$string .= '</tr>';
			$string .= '<tbody>';
		}

		$string .= '</table>';

		$string .= '<br>';

		$string .= '<a href="/forms/connections.php"><button type="button" class="btn btn-default btn-lg">Add</button></a>';
		$string .= '<button type="button" class="oneSelected btn btn-default btn-lg" onclick="redirectUser(this, \'/forms/connections.php?edit_id=\');" disabled>Edit</button>';
		$string .= '<button type="button" class="notNoneSelected btn btn-default btn-lg delete-button" id="delete" disabled>Delete</button>';

		$string .= '</div>';

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