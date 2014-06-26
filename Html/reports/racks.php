<?php
	include "/inc/database.php";
 ?>
<!DOCTYPE html>
<html lang="en">
	<head>
	    <?php include "/inc/header.php" ?>

		<title>Vendors</title>
	</head>

	<body>
		<div class="container">

			<?php include "/inc/navbar.php" ?>

			<div class="row">

				<?php include "/inc/sidebar.php" ?>

				<div class="col-md-10">
					<div class="jumbotron">

						<h1>Racks</h1>

						<?php echo tableStringForRacks(); ?>

						<p><a href="/forms/racks.php">Add Rack</a></p>

					</div> <!--jumbotron-->
				</div>
				<div class="col-md-4"></div>
			</div>

		</div> <!-- /container -->

		<?php include "/inc/footer.php" ?>

	</body>
</html>