<?php 
	include "../connect.php";
	function get_equipment_location ($equipment_object) {
		global $pdo;

		$query_affiliation = "$equipment_object->affiliated";
		$affiliation = $pdo->query($query_affiliation);

		if($equipment_object->affiliated == 'E'){
			$query_parent_equipment = "SELECT * FROM equipment WHERE id=$equipment_object->parent_equipment_id";

			$parent_equipment_resource = $pdo->query($query_parent_equipment);
			$parent_equipment_object = $parent_equipment_resource->fetchObject();

			return get_equipment_location($parent_equipment_object);
		}

		$query_racks = "SELECT * FROM racks WHERE id=$equipment_object->parent_rack_id";

		$rack_resource = $pdo->query($query_racks);
		$rack_row = $rack_resource->fetchObject();

		$room_query = "SELECT floor_location FROM rooms WHERE id=$rack_row->room_id";

		$room_resource = $pdo->query($room_query);
		$room_row = $room_resource->fetchObject();

		return $room_row->floor_location;
	}

	function get_equipment_vendor ($equipment_object) {
		global $pdo;

		$query_vendors = "SELECT * FROM vendors WHERE id=$equipment_object->vendor_id";

		$equipment_object = $pdo->query($query_vendors);
		$vendor_row = $equipment_object->fetchObject();

		return $vendor_row->vendor;
	}
 ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include "../header.php" ?>

		<title>Equipment</title>
	</head>

	<body>
		<div class="container">

			<?php include "../navbar.php" ?>

			<div class="row">

				<?php include "../sidebar.php" ?>

				<div class="col-md-10">
					<div class="jumbotron">
						<h1>Equipment</h1>
						<!--<form type="submit" method="post" action= "<?php echo $_SERVER["PHP_SELF"] ?>">-->

							<p><a value="listall" name="listall" href="equipment.php?link=listall" >List all</a></p>

						<!--</form>-->	
						
						<table class="table">
							
							<?php 
								
								if($_GET['link'] == 'listall'){
									$query = "SELECT * FROM `equipment`";

									echo "<tr>";
									echo "	<th>Model</th>";
									echo "	<th>Location</th>";
									echo "	<th>Vendor</th>";
									echo "</tr>";

									$row_resource = $pdo->query($query);

									while ($row = $row_resource->fetchObject()) {
										echo "<tr>";
										echo "	<td>" . $row->model . "</td>";
										echo "	<td>" . get_equipment_location($row) . "</td>";
										echo "	<td>" . get_equipment_vendor($row) . "</td>";
										echo "</tr>";
									}

								}
								
							 ?>	
						</table>
					</div>
				</div>
			</div> <!--row-->

			<?php include "../footer.php" ?>

		</div> <!-- /container -->

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> -->

		<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
		<script src="http://getbootstrap.com/assets/js/docs.min.js"></script>

	</body>
</html>