<?php
	include "../connect.php";
	global $pdo;

	$name = $_POST['inputProjectName'];
	$comment = $_POST['inputComment'];

	$query = "INSERT INTO Projects (name, comment) Values (:name, :comment)";

	$pdo->prepare($query)->execute(array(':name'=>$name, ':comment'=>$comment));

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
						<form role="form" method="post" action="<?php echo $PHP_SELF; ?>">
							<div class="form-group">
								<label for="inputProjectName">Project Name</label>
								<input type="text" name="inputProjectName" class="form-control" id="inputProjectName" placeholder="Enter Project Name" maxlength="45" size ="45">
							</div>
							<div class="form-group">
								<label for="inputComment">Comments</label>
								<textarea name="inputComment" class="form-control" id="inputComment" placeholder="Enter Optional Comments" cols="60" rows="4"></textarea>
							</div>
							<button type="submit" name="insert" class="btn btn-default">Insert</button>
						</form>
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