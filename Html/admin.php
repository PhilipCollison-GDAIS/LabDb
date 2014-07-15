<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include "inc/header.php" ?>

		<title>Admin</title>
	</head>

	<body>
		<div class="container">

			<?php include "inc/navbar.php" ?>

			<div class="row">
				<?php include "inc/sidebar.php" ?>

				<div class="col-md-10">
					<div class="jumbotron">
						<h1>Admin</h1>

						<p>Forms</p>

						<p><a href="forms/rooms.php">Rooms</a></p>
						<p><a href="forms/projects.php">Projects</a></p>
						<p><a href="forms/vendors.php">Vendors</a></p>

						<br>

						<p>Manage Backups</p>

						<p><a href="#">Create Backup</a></p>
						<p><a href="#">Restore From Backup</a></p>

						<br>

						<p>phpMyAdmin</p>

						<p><a href="#">Link</a></p>

					</div>
				</div>
			</div> <!--row-->

		</div> <!-- /container -->

		<?php include "inc/footer.php" ?>

	</body>
</html>
