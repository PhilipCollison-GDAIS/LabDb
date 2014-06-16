<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<link rel="shortcut icon" href="http://getbootstrap.com/dist/css/bootstrap.min.css">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="http://getbootstrap.com/dist/css/bootstrap.min.css">

		<!-- Custom styles for this template -->
		<link href="http://getbootstrap.com/examples/navbar/navbar.css" rel="stylesheet">	

		<link rel="stylesheet" href="docs.css">

		<title>Main</title>
	</head>

	<body>
		<div class="container">

			<?php include "navbar.php"; ?>

			<div class="row">
				<?php include "sidebar.php"; ?>

				<div class="col-md-10">
					<div class="jumbotron">
						<h1>Home Page</h1>
						<p>This is a interactive web application for server room management.</p>
					</div>
				</div>
			</div> <!--row-->

			<?php include "footer.php"; ?>

		</div> <!-- /container -->

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> -->

		<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
		<script src="http://getbootstrap.com/assets/js/docs.min.js"></script>

	</body>
</html>