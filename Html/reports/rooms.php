<?php
	include "/inc/connect.php";
 ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include "/inc/header.php" ?>

		<title>Rooms</title>
	</head>

	<body>
		<div class="container">

			<?php include "/inc/navbar.php" ?>

			<div class="row">
				<?php include "/inc/sidebar.php" ?>

				<div class="col-md-10">
					<div class="jumbotron">
						<h1>Rooms</h1>

						<table class="table">

							<?php

								$query = "SELECT * FROM `rooms`";

								echo "<tr>";
								echo "	<th>Room Number</th>";
								echo "	<th>Comment</th>";
								echo "</tr>";

								$row_resource = $pdo->query($query);

								while ($row = $row_resource->fetchObject()) {
									echo "<tr>";
									echo "	<td>" . $row->room_number . "</td>";
									echo "	<td>" . $row->comment . "</td>";
									echo "	<td><a href='#'>Edit</a></td>";
									echo "</tr>";
								}

							 ?>

						</table>

						<p><a href="../forms/rooms.php">Add room</a></p>

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