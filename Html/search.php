<?php
include "/inc/connect.php";
include "/inc/database.php";

if (!isset($_GET['search'])) {

} else if ($_GET['search'] === "rack") {

} else if ($_GET['search'] === "equipment") {

} else if ($_GET['search'] === "port") {

} else if ($_GET['search'] === "connection") {

} else {
	// Invalid search query, redirect user
	header('Location: ' . $_SERVER['PHP_SELF']);
	exit;
}
 ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include "/inc/header.php" ?>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript">

		$(function() {
			$(".search_button").click(function() {
				var searchString 	= $('#search').val();
				var data			= 'search=' + searchString;

				// getting the value that user typed
				searchString	= $("#search_box").val();
				// forming the queryString
				data			+= '&item=' + searchString;

				data = {'a':'1', 'b':'2', 'c':'3'};

				// ajax call
				$.ajax({
					type: "POST",
					url: "do_search.php",
					data: data,
					beforeSend: function(html) { // this happens before actual call
						$(".word").html(searchString);
					},
					success: function(html){ // this happens after we get results
						$("#results").html('');
						$("#results").append(html);
					}
				});

				return false;
			});

		});
		</script>

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
							<select name="search" onchange="this.form.submit();">
								<option <?php if($_GET['search'] != "rack" && $_GET['search'] != "equipment" && $_GET['search'] != "port" && $_GET['search'] != "connection"){print "selected=\"selected\"";} ?>></option>
								<option value="rack" <?php if($_GET['search'] === "rack"){print "selected=\"selected\"";} ?>>Rack</option>
								<option value="equipment" <?php if($_GET['search'] === "equipment"){print "selected=\"selected\"";} ?>>Equipment</option>
								<option value="port" <?php if($_GET['search'] === "port"){print "selected=\"selected\"";} ?>>Port</option>
								<option value="connection" <?php if($_GET['search'] === "connection"){print "selected=\"selected\"";} ?>>Connection</option>
							</select>
						</form>

						<br>
						<br>

						<?php if (!isset($_GET['search'])) { ?>

						<p>After you choose some option above the rest of the page will dynamically generate here.</p>

						<p>This will bring up all of your search fields. For example if you choose to search through Equipment then here will be search options for vendor, serial number, GFE_id, model, and ports.</p>

						<?php } else if ($_GET['search'] === "equipment") { ?>

						<p>Equipment: </p>
<!--
						<ul>
							<li>Vendor</li>
							<li>Rack</li>
							<li>Model</li>
							<li>Serial Number</li>
							<li>Port Types</li>
							<li>GFE ID</li>
							<li>Name</li>
							<li>Projects</li>
						</ul>
 -->
						<?php } else if ($_GET['search'] === "rack") { ?>

						<p>Racks: </p>
<!--
						<ul>
							<li>Equipment</li>
							<li>Connection</li>
							<li>Name</li>
							<li>Location</li>
							<li>Max Power</li>
						</ul>
 -->
						<?php } else if ($_GET['search'] === "connection") { ?>

						<p>Connections: </p>
<!--
						<ul>
							<li>Equipment</li>
							<li>Racks</li>
							<li>Connection Type</li>
							<li>Port</li>
							<li>Projects</li>
						</ul>
 -->
						<?php } else if ($_GET['search'] === "port") { ?>

						<p>Ports: </p>
<!--
						<ul>
							<li>Connections</li>
							<li>Equipment</li>
							<li>Racks</li>
							<li>Connection Type</li>
							<li>Name</li>
						</ul>
 -->
						<?php } else { ?>
							<?php echo '<script>window.location = "' . strtok($_SERVER['REQUEST_URI'], '?') . '";</script>'; ?>
							<?php exit; ?>
						<?php } ?>

						<form method="post" action="/do_search.php">
							<table class="search_table" width="50%">

								<?php if (in_array($_GET['search'], array("rack", "port", "connection"))) { ?>
								<!-- Row for equipment -->
								<tr>
									<td><label for="equipment">Equipment</label></td>
									<td><input type="text" name="equipment" id="equipment" placeholder="Enter Equipment" maxlength="20" size ="20"></td>
								</tr>
								<?php } ?>

								<?php if (in_array($_GET['search'], array("rack", "port"))) { ?>
								<!-- Row for connection -->
								<tr>
									<td><label for="connection">Connection</label></td>
									<td><input type="text" name="connection" id="connection" placeholder="Enter Connection" maxlength="20" size ="20"></td>
								</tr>
								<?php } ?>

								<?php if (in_array($_GET['search'], array("equipment", "port", "connection"))) { ?>
								<!-- Row for rack input -->
								<tr>
									<td><label for="rack">Rack</label></td>
									<td><input type="text" name="rack" id="rack" placeholder="Enter Rack" maxlength="20" size ="20"></td>
								</tr>
								<?php } ?>

								<?php if (in_array($_GET['search'], array("connection"))) { ?>
								<!-- Row for port -->
								<tr>
									<td><label for="port">Port</label></td>
									<td><input type="text" name="port" id="port" placeholder="Enter Port" maxlength="20" size ="20"></td>
								</tr>
								<?php } ?>

								<?php if (in_array($_GET['search'], array("equipment"))) { ?>
								<!-- Row for vendor -->
								<tr>
									<td><label for="vendor">Vendor</label></td>
									<td><input type="text" name="vendor" id="vendor" placeholder="Enter Vendor" maxlength="20" size ="20"></td>
								</tr>
								<?php } ?>

								<?php if (in_array($_GET['search'], array("equipment"))) { ?>
								<!-- Row for model -->
								<tr>
									<td><label for="model">Model</label></td>
									<td><input type="text" name="model" id="model" placeholder="Enter Model" maxlength="20" size ="20"></td>
								</tr>
								<?php } ?>

								<?php if (in_array($_GET['search'], array("equipment"))) { ?>
								<!-- Row for serial number -->
								<tr>
									<td><label for="serial_num">Serial Number</label></td>
									<td><input type="text" name="serial_num" id="serial_num" placeholder="Enter Serial Number" maxlength="20" size ="20"></td>
								</tr>
								<?php } ?>

								<?php if (in_array($_GET['search'], array("equipment", "port", "connection"))) { ?>
								<!-- Row for port type -->
								<tr>
									<td><label for="connector_type">Connection Type</label></td>
									<td><input type="text" name="connector_type" id="connector_type" placeholder="Enter Connection Type" maxlength="20" size ="20"></td>
								</tr>
								<?php } ?>

								<?php if (in_array($_GET['search'], array("equipment"))) { ?>
								<!-- Row for GFE ID -->
								<tr>
									<td><label for="gfe_id">GFE ID</label></td>
									<td><input type="text" name="gfe_id" id="gfe_id" placeholder="Enter GFE ID" maxlength="20" size ="20"></td>
								</tr>
								<?php } ?>

								<?php if (in_array($_GET['search'], array("rack", "equipment", "port"))) { ?>
								<!-- Row for name -->
								<tr>
									<td><label for="name">Name</label></td>
									<td><input type="text" name="name" id="name" placeholder="Enter Name" maxlength="20" size ="20"></td>
								</tr>
								<?php } ?>

								<?php if (in_array($_GET['search'], array("equipment", "connection"))) { ?>
								<!-- Row for project -->
								<tr>
									<td><label for="project">Project</label></td>
									<td><input type="text" name="project" id="project" placeholder="Enter Project" maxlength="20" size ="20"></td>
								</tr>
								<?php } ?>

								<?php if (in_array($_GET['search'], array("rack"))) { ?>
								<!-- Row for location -->
								<tr>
									<td><label for="location">Location</label></td>
									<td><input type="text" name="location" id="location" placeholder="Enter Location" maxlength="20" size ="20"></td>
								</tr>
								<?php } ?>

								<?php if (in_array($_GET['search'], array("rack"))) { ?>
								<!-- Row for max power -->
								<tr>
									<td><label for="max_power">Max Power</label></td>
									<td><input type="text" name="max_power" id="max_power" placeholder="Enter Max Power" maxlength="20" size ="20"></td>
								</tr>
								<?php } ?>

							</table>

							<br>

							<input type="submit" value="Submit" class="search_button">
						</form>

						<br>
						<br>
						<br>

						<p>Results will appear in a table here, pagination optional.</p>

						<p id="results" class="update"></p>

					</div> <!--jumbotron-->
				</div>
				<div class="col-md-4"></div>
			</div>

		</div> <!-- /container -->

		<?php include "/inc/footer.php" ?>

	</body>
</html>