<?php
	include "/LabDB/Html/inc/connect.php";
	global $pdo;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	    <?php include "/LabDB/Html/inc/header.php" ?>

		<title>Vendors</title>
	</head>

	<body>
		<div class="container">

			<?php include "/LabDB/Html/inc/navbar.php" ?>

			<div class="row">
				<?php include "/LabDB/Html/inc/sidebar.php" ?>

				<div class="col-md-10">
					<div class="jumbotron">

						<h1>Racks</h1>

						<table class="table">

							<?php

								$query = "SELECT * FROM `Racks`";

								echo "<tr>";
								echo "	<th>Name</th>";
								echo "	<th>Old Name</th>";
								echo "	<th>Room ID</th>";
								echo "	<th>Floor Location</th>";
								echo "	<th>Height</th>";
								echo "	<th>Width ID</th>";
								echo "	<th>Depth ID</th>";
								echo "	<th>Max Power</th>";
								echo "	<th>Comments</th>";
								echo "</tr>";

								$row_resource = $pdo->query($query);

								while ($row = $row_resource->fetchObject()) {
									echo "<tr>";
									echo "	<td><a href='#'>" . $row->name . "</a></td>";
									echo "	<td>" . $row->old_name . "</td>";
									echo "	<td>" . $row->room_id . "</td>";
									echo "	<td>" . $row->floor_location . "</td>";
									echo "	<td>" . $row->height_ru . "</td>";
									echo "	<td>" . $row->width_id . "</td>";
									echo "	<td>" . $row->depth_id . "</td>";
									echo "	<td>" . $row->max_power . "</td>";
									echo "	<td>" . $row->comment . "</td>";
									echo "	<td><a href='#'>Edit</a></td>";
									echo "</tr>";
								}

							 ?>

						</table>

						<p><a href="../forms/racks.php">Add Rack</a></p>

					</div> <!--jumbotron-->
				</div>
				<div class="col-md-4"></div>
			</div>

		</div> <!-- /container -->

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>-->
		<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"> </script>
		<script src="http://getbootstrap.com/assets/js/docs.min.js"></script>
	</body>
</html>