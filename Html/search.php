<?php
	include "/inc/connect.php";
 ?>
<!DOCTYPE html>
<html lang="en">
	<head>
	    <?php include "/inc/header.php" ?>

		<title>Search</title>
	</head>

	<body>
		<div class="container">

			<?php include "/inc/navbar.php" ?>

			<div class="row">
				<?php include "/inc/sidebar.php" ?>

				<div class="col-md-10">
					<div class="jumbotron">

						<h1>Search</h1>

						<p>There is a dropdown or a set of radio buttons here that asks what would you like to search</p>

						<br>

						<p>After you choose some option above the rest of the page will dynamically generate here.</p>

						<p>This will bring up all of your search fields. For example if you choose to search through Equipment then here will be search options for vendor, serial number, GFE_id, model, and ports.</p>

						<br>

						<p>Results will appear in a table here, pagination optional.</p>

						<form role="form" method="post" action="/forms/equipment.php?submit">
							<div class="form-group">
								<label for="inputDepthID">Depth</label>
								<select name="inputDepthID" class="form-control">
									<option>Equipment</option>
									<option>Racks</option>
									<option>Vendors</option>
								</select>
							</div>
						</form>


					</div> <!--jumbotron-->
				</div>
				<div class="col-md-4"></div>
			</div>

		</div> <!-- /container -->

		<?php include "/inc/footer.php" ?>

	</body>
</html>