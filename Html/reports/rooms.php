<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include "../header.php" ?>

		<title>Rooms</title>
	</head>

	<body>
		<div class="container">

			<?php include "../navbar.php" ?>

			<div class="row">
				<?php include "../sidebar.php" ?>

				<div class="col-md-10">
					<div class="jumbotron">
						<h1>Rooms</h1>

						<p><a value="listall" name="listall" href="equipment.php?link=listall" >List all</a></p>

						<table class="table">

							<tr>
								<th>Building</th>
								<th>Room Number</th>
							</tr>

							<tr>
								<td>building 1</td>
								<td>room number 01</td>

								<td>Button to edit 01</td>
							</tr>

							<tr>
								<td>building 1</td>
								<td>room number 02</td>

								<td>Button to edit 02</td>
							</tr>

						</table>

						<p><a href="./../forms/rooms.php">Button to add room</a></p>

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