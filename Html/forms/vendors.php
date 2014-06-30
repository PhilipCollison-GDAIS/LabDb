<?php
	include "/inc/connect.php";
	global $pdo;

	$vendor = $_POST['inputVendor'];
	$comment = $_POST['inputComment'];

	$query = "INSERT INTO vendors (vendor, comment) Values (:vendor, :comment)";

	$pdo->prepare($query)->execute(array(':vendor'=>$vendor, ':comment'=>$comment));

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
						<form role="form" method="post" action="<?php echo $PHP_SELF; ?>">
							<div class="form-group">
								<label for="inputVendor">Vendor</label>
								<input type="text" name="inputVendor" class="form-control" id="inputVendor" placeholder="Enter Vendor" maxlength="20" size ="20" autofocus="autofocus">
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

		<?php include "/inc/footer.php" ?>

	</body>
</html>