<?php
	include "../connect.php";
	global $pdo;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	    <?php include "../header.php" ?>

		<title>Projects</title>
	</head>

	<body>
		<div class="container">

			<?php include "../navbar.php" ?>

			<div class="row">
				<?php include "../sidebar.php" ?>

				<div class="col-md-10">
					<div class="jumbotron">

						<h1>Projects</h1>

						<table class="table">

							<?php

								$query = "SELECT * FROM `Projects`";

								echo "<tr>";
								echo "	<th>Project Name</th>";
								echo "	<th>Comments</th>";
								echo "</tr>";

								$row_resource = $pdo->query($query);

								while ($row = $row_resource->fetchObject()) {
									echo "<tr>";
									echo "	<td><a href='#'>" . $row->name . "</a></td>";
									echo "	<td>" . $row->comment . "</td>";
									echo "  <td><a href='#'>Edit this project</a></td>";
									echo "</tr>";
								}

							 ?>

						</table>

						<p><a href="./../forms/projects.php">Add Project</a></p>

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