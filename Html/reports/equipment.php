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
						<p><a href="#" action= "<?php echo $_SERVER["PHP_SELF"] ?>" ></a>List all</p>
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