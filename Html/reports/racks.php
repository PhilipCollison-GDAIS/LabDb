<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";
include "/inc/database.php";
require_once "/delete/equipment.php";
require_once "/delete/ports.php";

class RacksReport implements reportsInterface{
	public function redirect(){
		global $pdo;

		if(isset($_GET['id'])){
			// If the rack that is being searched for does not exist, redirect the user
			$query = 'SELECT EXISTS(SELECT 1 FROM racks WHERE id = :id) AS redirect';

			$q = $pdo->prepare($query);
			$q->bindParam(':id', $_GET['id'] , PDO::PARAM_INT);
			$q->execute();

			if($q->fetchObject()->redirect === "0"){
				header('Location: ' . $_SERVER['PHP_SELF']);
				exit;
			}
		}
	}

	public function getTitle(){
		return 'Racks';
	}

	public function getHeading(){
		if(empty($_GET)){
			return 'Racks';
		} else {
			return '<a href="/reports/racks.php">Racks</a>';
		}
	}

	public function getTableString(){
		global $pdo;

		$string = '<div class="table-n-buttons" name="main-table-for-racks">';

		$string .= '<table class="table data-table">';

		$string .= '<thead>';
		$string .= '<tr>';
		$string .= '<th>Name</th>';
		$string .= '<th>Old Name</th>';
		$string .= '<th>Room Number</th>';
		$string .= '<th>Floor Location</th>';
		$string .= '<th>Dimensions (WxHxD) </th>';
		$string .= '<th>Max Power</th>';
		$string .= '<th>Comments</th>';
		$string .= '</tr>';
		$string .= '</thead>';

		$query = 'SELECT racks.id, name, old_name, room_number, floor_location, height_ru, width, depth, max_power, racks.comment
					FROM racks, rooms, widths, depths
					WHERE racks.room_id = rooms.id
					AND racks.width_id = widths.id
					AND racks.depth_id = depths.id
					ORDER BY room_number, name';
					// TODO: How is is that the ORDER BY clauses should be ordered?
					//		 This decision depends on the conventions for floor_location and name.

		$row_resource = $pdo->query($query);

		while ($row = $row_resource->fetchObject()) {
			$string .= '<tr>';
			$string .= '<td><a href="/reports/racks.php?id=' . $row->id . '">' . $row->name . '</a></td>';
			$string .= '<td>' . $row->old_name . '</td>';
			$string .= '<td>' . $row->room_number . '</td>';
			$string .= '<td>' . $row->floor_location . '</td>';
			$string .= '<td>' . $row->height_ru . ' x ' . $row->width . ' x ' . $row->depth . '</td>';
			$string .= '<td>' . $row->max_power . '</td>';
			$string .= '<td>' . $row->comment . '</td>';
			$string .= '</tr>';
		}

		$string .= '</table>';

		$string .= '<br>';

		$string .= '<a href="/forms/racks.php"><button type="button" class="oneSelected btn btn-default btn-lg">Add</button></a>';
		$string .= '<a onclick="addURL(this)" href="/forms/racks.php?edit_id="><button type="button" class="oneSelected btn btn-default btn-lg" disabled>Edit</button></a>';
		$string .= '<a onclick="addURL(this)" href="/forms/racks.php?copy_id="><button type="button" class="oneSelected btn btn-default btn-lg" disabled>Copy</button></a>';

		$string .= '</div>';

		return $string;
	}

	public function getIdString($id){
		global $pdo;

		$query = 'SELECT racks.id, name, old_name, room_number, floor_location, height_ru, width, depth, max_power, racks.comment
					FROM racks, rooms, widths, depths
					WHERE racks.room_id = rooms.id
					AND racks.width_id = widths.id
					AND racks.depth_id = depths.id
					AND racks.id = :id';

		$q = $pdo->prepare($query);
		$q->bindParam(':id', $id, PDO::PARAM_INT);
		$q->execute();

		$row = $q->fetchObject();

		// Used in modals
		$rack_height = $row->height_ru;

		$string = '<table class="table" style="width: 400px; font-size: 16px;">';
		$string .= '<tr><td><strong>Name: </strong></td><td>' . $row->name . '</td></tr>';
		if (!empty($row->old_name)) {
			$string .= '<tr><td><strong>Old Name: </strong></td><td>' . $row->old_name . '</td></tr>';
		}
		$string .= '<tr><td><strong>Room Number: </strong></td><td>' . $row->room_number . '</td></tr>';
		if (!empty($row->floor_location)) {
			$string .= '<tr><td><strong>Floor Location: </strong></td><td>' . $row->floor_location . '</td></tr>';
		}
		$string .= '<tr><td><strong>Dimensions (WxHxD): </strong></td><td>' . $row->height_ru . ' x ' . $row->width . ' x ' . $row->depth . '</td></tr>';
		$string .= '<tr><td><strong>Max Power: </strong></td><td>' . $row->max_power . '</td></tr>';
		if (!empty($row->comment)) {
			$string .= '<tr><td><strong>Comments: </strong></td><td>' . $row->comment . '</td></tr>';
		}
		$string .= '</table>';

		$string .= '<br>';

		$string .= '<div class="table-n-buttons" name="equipment-table-for-racks">';

		$string .= '<h2>Equipment</h2>';

		$string .= '<table class="table data-table">';
		$string .= '<thead>';
		$string .= '<tr>';
		$string .= '<th>Elevation</th>';
		$string .= '<th>Serial Number</th>';
		$string .= '<th>Barcode Number</th>';
		$string .= '<th>Name</th>';
		$string .= '<th>Vendor</th>';
		$string .= '<th>Model</th>';
		$string .= '<th>GFE ID</th>';
		$string .= '<th>Comment</th>';
		$string .= '</tr>';
		$string .= '</thead>';

		$query = 'SELECT equipment.id AS id, elevation, model, vendor, equipment.name AS name, serial_num, barcode_number, GFE_id, equipment.comment AS comment
					FROM equipment, vendors, affiliations
					WHERE equipment.vendor_id = vendors.id
						AND affiliations.id = equipment.id
						AND affiliations.parent_rack_id = :id
					ORDER BY elevation DESC';

		$q = $pdo->prepare($query);
		$q->bindParam(':id', $id, PDO::PARAM_INT);
		$q->execute();

		while ($row = $q->fetchObject()) {
			$string .= '<tr value="' . $row->id . '">';
			$string .= '<td>' . $row->elevation . '</td>';
			$string .= '<td><a href="/reports/equipment.php?id=' . $row->id . '">' . $row->serial_num . '</a></td>';
			$string .= '<td>' . $row->barcode_number . '</td>';
			$string .= '<td>' . $row->name . '</td>';
			$string .= '<td>' . $row->vendor . '</td>';
			$string .= '<td>' . $row->model . '</td>';
			$string .= '<td>' . $row->GFE_id . '</td>';
			$string .= '<td>' . $row->comment . '</td>';
			$string .= '</tr>';
		}

		$string .= '</table>';

		$string .= '<br>';

		ob_start();
		include "/inc/modal_buttons/equipment_button_for_racks.php";
		$string .= trim(ob_get_clean());
		$string .= '<a onclick="addURL(this)" href="/forms/equipment.php?edit_id="><button type="button" class="oneSelected btn btn-default btn-lg" disabled>Edit</button></a>';
		$string .= '<a onclick="addURL(this)" href="/forms/equipment.php?copy_id="><button type="button" class="oneSelected btn btn-default btn-lg" disabled>Copy</button></a>';
		$string .= '<button type="button" class="notNoneSelected btn btn-default btn-lg delete-button" disabled>Delete</button>';

		$string .= '</div>';

		$string .= '<br>';

		$string .= '<div class="table-n-buttons" name="optical_cassette-table-for-racks">';

		$string .= '<h2>Patch Panels</h2>';

		$string .= '<table class="table data-table">';
		$string .= '<thead>';
		$string .= '<tr>';
		$string .= '<th>Connector Type</th>';
		$string .= '<th>Name</th>';
		$string .= '<th>Connection</th>';
		$string .= '<th>Gender</th>';
		$string .= '<th>Type</th>';
		$string .= '</tr>';
		$string .= '</thead>';

		$query = 'SELECT connector_type, ports.name, ports.id, connector_gender, connector_types.affiliated AS type
					FROM ports, connector_types, optical_cassettes
					WHERE ports.connector_type_id = connector_types.id
						AND ports.optical_cassette_id = optical_cassettes.id
						AND optical_cassettes.rack_id = :id
					ORDER BY connector_types.connector_type, ports.name';

		$q = $pdo->prepare($query);
		$q->bindParam(':id', $id);
		$q->execute();

		while ($row = $q->fetchObject()) {
			$string .= '<tr value="' . $row->id . '">';
			$string .= '<td>' . $row->connector_type . '</td>';
			$string .= '<td>' . $row->name . '</td>';
			$string .= '<td>' . 'conditional link' . '</td>';
			$string .= '<td>';
			$string .= $row->connector_gender === "F" ? 'Female' : 'Male';
			$string .= '</td>';
			$string .= '<td>';
			$string .= $row->type === "E" ? 'Electrical' : 'Optical';
			$string .= '</td>';
			// $string .= '<td><a href="/forms/ports.php?edit_id=' . $row->id . '">Edit</a>&nbsp;&nbsp;&nbsp;<a href="/forms/ports.php?copy_id=' . $row->id . '">Copy</a></td>';
			$string .= '</tr>';
		}

		$string .= '</table>';

		$string .= '<br>';

		ob_start();
		include "/inc/modal_buttons/optical_cassette_button_for_racks.php";
		$string .= trim(ob_get_clean());
		$string .= '<a onclick="addURL(this)" href="/forms/ports.php?edit_id="><button type="button" class="oneSelected btn btn-default btn-lg" disabled>Edit</button></a>';
		$string .= '<a onclick="addURL(this)" href="/forms/ports.php?copy_id="><button type="button" class="oneSelected btn btn-default btn-lg" disabled>Copy</button></a>';
		$string .= '<button type="button" class="notNoneSelected btn btn-default btn-lg delete-button" disabled>Delete</button>';

		$string .= '</div>';

		return $string;
	}
}

$report = new RacksReport();

include "/inc/reports.php";
?>