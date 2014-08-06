<?php
require_once "/inc/connect.php";
// global $pdo;

if (isset($_POST['search'])) {

	/* Rack search	*/
	if ($_POST['search'] === "rack") {
		echo "rack search is not implemented:";
		echo '<pre>';
		var_dump($_POST);
		echo '</pre>';
	} else

	/* Equipment search */
	if ($_POST['search'] === "equipment") {
		echo "equipment search is not implemented:";
		echo '<pre>';
		var_dump($_POST);
		echo '</pre>';
	} else

	/* Port search */
	/* User has search options of Racks, Equipment, Connection, Connection Type, and Name. */
	if ($_POST['search'] === "port") {
		echo "port search is not implemented:";
		echo '<pre>';
		var_dump($_POST);
		echo '</pre>';

		$string = '<table id="search-table" class="table data-table">';

		$string .= '<thead>';
		$string .= '<tr>';
		$string .= '<th>Serial Number</th>';
		$string .= '<th>Rack</th>';
		$string .= '<th>Location</th>';
		$string .= '<th>Vendor</th>';
		$string .= '<th>Model</th>';
		$string .= '<th>Barcode</th>';
		$string .= '<th>GFE ID</th>';
		$string .= '<th>Comments</th>';
		$string .= '<th><a href="/forms/equipment.php">Add Equipment</a></th>';
		$string .= '</tr>';
		$string .= '</thead>';

		$query = 'SELECT equipment.id, barcode_number, vendor, model, serial_num, GFE_id, building_name, room_number, racks.name AS rack_name, racks.id AS rack_id, equipment.comment
					FROM equipment, vendors, racks, rooms, affiliations
					WHERE equipment.vendor_id = vendors.id
						AND equipment.id = affiliations.id
						AND affiliations.parent_rack_id = racks.id
						AND racks.room_id = rooms.id
					ORDER BY rooms.id, racks.id, serial_num';

		$row_resource = $pdo->query($query);

		while ($row = $row_resource->fetchObject()) {
			$string .= '<tr>';
			$string .= '<td><a href="/reports/equipment.php?id=' . $row->id . '">' . $row->serial_num . '</a></td>';
			$string .= '<td><a href="/reports/racks.php?id=' . $row->rack_id . '">' . $row->rack_name . '</a></td>';
			$string .= '<td>' . $row->room_number . " " .  $row->building_name . '</td>';
			$string .= '<td>' . $row->vendor . '</td>';
			$string .= '<td>' . $row->model . '</td>';
			$string .= '<td>' . $row->barcode_number . '</td>';
			$string .= '<td>' . $row->GFE_id . '</td>';
			$string .= '<td>' . $row->comment . '</td>';
			$string .= '<td><a href="/forms/equipment.php?edit_id=' . $row->id . '">Edit</a>&nbsp;&nbsp;&nbsp;<a href="/forms/equipment.php?copy_id=' . $row->id . '">Copy</a></td>';
			$string .= '</tr>';
		}

		$string .= '</table>';

		echo $string;

	} else

	/* Connection search */
	if ($_POST['search'] === "connection") {
		echo "connection search is not implemented:";
		echo '<pre>';
		var_dump($_POST);
		echo '</pre>';
	}

	/* Something has caused an invalid query  */
	else {
		echo "Your search was somehow invalid. Please contact your administrator:";
		echo '<pre>';
		var_dump($_POST);
		echo '</pre>';
	}

	exit;

} else {
	exit;
}