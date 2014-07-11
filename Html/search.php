<?php
	include "/inc/connect.php";
	include "/inc/database.php";
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

						<form role="form" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<label for="search">What would you like to search for:   </label>
							<select name="search" <?php if(!isset($_GET['search'])) echo 'class="DropdownInitiallyBlank"' ?> onchange="this.form.submit();">
								<option value="equipment" <?php if($_GET['search'] === "equipment"){print "selected=\"selected\"";} ?>>Equipment</option>	
								<option value="rack" <?php if($_GET['search'] === "rack"){print "selected=\"selected\"";} ?>>Rack</option>	
								<option value="connection" <?php if($_GET['search'] === "connection"){print "selected=\"selected\"";} ?>>Connection</option>	
								<option value="port" <?php if($_GET['search'] === "port"){print "selected=\"selected\"";} ?>>Port</option>	
							</select>
						</form>

						<?php if (!isset($_GET['search'])) { ?>

						<?php } else if ($_GET['search'] === "equipment") { ?>

						<?php } else if ($_GET['search'] === "rack") { ?>

						<?php } else if ($_GET['search'] === "connection") { ?>

						<?php } else if ($_GET['search'] === "port") { ?>

						<?php } else { ?>
							<?php echo '<script>window.location = "' . strtok($_SERVER['REQUEST_URI'], '?') . '";</script>'; ?>
							<?php exit; ?>
						<?php } ?>

						<br>

						<p>After you choose some option above the rest of the page will dynamically generate here.</p>

						<p>This will bring up all of your search fields. For example if you choose to search through Equipment then here will be search options for vendor, serial number, GFE_id, model, and ports.</p>

						<br>

						<p>Results will appear in a table here, pagination optional.</p>

						<br>

						<p>-------------------------------------------------------------------</p>

						<br>


					</div> <!--jumbotron-->
				</div>
				<div class="col-md-4"></div>
			</div>

		</div> <!-- /container -->

		<?php include "/inc/footer.php" ?>

	</body>
</html>