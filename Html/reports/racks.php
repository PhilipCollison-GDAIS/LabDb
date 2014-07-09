<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";
include "/inc/database.php";

class RacksReport implements reportsInterface{
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

		$string = '<table class="table">';

		$string .= '<tr>';
		$string .= '<th>Name</th>';
		$string .= '<th>Old Name</th>';
		$string .= '<th>Room Number</th>';
		$string .= '<th>Floor Location</th>';
		$string .= '<th>Dimensions (WxHxD) </th>';
		$string .= '<th>Max Power</th>';
		$string .= '<th>Comments</th>';
		$string .= '<th><a href="/forms/racks.php">Add Rack</a></th>';
		$string .= '</tr>';

		$query = 'SELECT racks.id, name, old_name, room_number, floor_location, height_ru, width, depth, max_power, racks.comment
					FROM racks, rooms, widths, depths
					WHERE racks.room_id = rooms.id
					AND racks.width_id = widths.id
					AND racks.depth_id = depths.id
					ORDER BY room_number, name';
					// TODO: How is is that the ORDER BY clauses should be ordered?
					//       This decision depends on the conventions for floor_location and name.

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
			$string .= '<td><a href="/forms/racks.php?edit_id=' . $row->id . '">Edit</a>&nbsp;&nbsp;&nbsp;<a href="/forms/racks.php?copy_id=' . $row->id . '">Copy</a></td>';
			$string .= '</tr>';
		}

		$string .= '</table>';

		return $string;
	}

	public function getIdString($id){
		if(!isset($id)){
			return '<br>';
		}

		global $pdo;

		$query = 'SELECT racks.id, name, old_name, room_number, floor_location, height_ru, width, depth, max_power, racks.comment
					FROM racks, rooms, widths, depths
					WHERE racks.room_id = rooms.id
					AND racks.width_id = widths.id
					AND racks.depth_id = depths.id
					AND racks.id = :id
					ORDER BY room_number, name';

		$q = $pdo->prepare($query);
		$q->bindParam(':id', $id, PDO::PARAM_INT);
		$q->execute();

		$row = $q->fetchObject();

		$string = '<table class="table" style="width: 400px; font-size: 16px;">';
		$string .= '<tr><td><strong>Name: </strong></td><td>' . $row->name . '</td></tr>';
		if (!is_null($row->old_name)) {
			$string .= '<tr><td><strong>Old Name: </strong></td><td>' . $row->old_name . '</td></tr>';
		}
		$string .= '<tr><td><strong>Room Number: </strong></td><td>' . $row->room_number . '</td></tr>';
		if (!is_null($row->comment)) {
					$string .= '<tr><td><strong>Floor Location: </strong></td><td>' . $row->floor_location . '</td></tr>';
		}
		$string .= '<tr><td><strong>Dimensions (WxHxD): </strong></td><td>' . $row->height_ru . ' x ' . $row->width . ' x ' . $row->depth . '</td></tr>';
		$string .= '<tr><td><strong>Max Power: </strong></td><td>' . $row->max_power . '</td></tr>';
		if (!is_null($row->comment)) {
			$string .= '<tr><td><strong>Comments: </strong></td><td>' . $row->comment . '</td></tr>';
		}
		$string .= '</table>';

		$string .= '<br>';

		$string .= '<table class="table">';
		$string .= '<tr>';
		$string .= '<th>Elevation</th>';
		$string .= '<th>Model</th>';
		$string .= '<th>Vendor</th>';
		$string .= '<th>Name</th>';
		$string .= '<th>Serial Number</th>';
		$string .= '<th>Barcode Number</th>';
		$string .= '<th>GFE ID</th>';
		$string .= '<th>Comment</th>';
		$string .= '<th>';
		ob_start();
		include "/inc/modal_buttons/equipment_button.php";
		$string .= ob_get_clean();
		$string .= '</th>';
		$string .= '</tr>';

		// $query = 'SELECT equipment.id, elevation, model, vendor, equipment.name AS name, serial_num, barcode_number, GFE_id, equipment.comment AS comment
		// 			FROM equipment, vendors, affiliations
		// 			WHERE equipment.vendor_id = vendors.id AND affiliations.id = equipment.id AND equipment_id = :id
		// 			ORDER BY connector_types.connector_type, ports.name';
		$query = 'SELECT equipment.id AS id, elevation, model, vendor, equipment.name AS name, serial_num, barcode_number, GFE_id, equipment.comment AS comment
					FROM equipment, vendors, affiliations
					WHERE equipment.vendor_id = vendors.id AND affiliations.parent_rack_id = :id AND affiliations.id = equipment.id
					ORDER BY elevation';

		$q = $pdo->prepare($query);
		$q->bindParam(':id', $id, PDO::PARAM_INT);
		$q->execute();

		while ($row = $q->fetchObject()) {
			$string .= '<tr>';
			$string .= '<td>' . $row->elevation . '</td>';
			$string .= '<td>' . $row->model . '</td>';
			$string .= '<td>' . $row->vendor . '</td>';
			$string .= '<td>' . $row->name . '</td>';
			$string .= '<td><a href="/reports/equipment.php?id=' . $row->id . '">' . $row->serial_num . '</a></td>';
			$string .= '<td>' . $row->barcode_number . '</td>';
			$string .= '<td>' . $row->GFE_id . '</td>';
			$string .= '<td>' . $row->comment . '</td>';
			$string .= '<td><a href="/forms/ports.php?edit_id=' . $row->id . '">Edit</a>&nbsp;&nbsp;&nbsp;<a href="/forms/ports.php?copy_id=' . $row->id . '">Copy</a></td>';
			$string .= '</tr>';
		}

		$string .= '</table>';

		return $string;
	}
}

$report = new RacksReport();

include "/inc/reports.php";
?>