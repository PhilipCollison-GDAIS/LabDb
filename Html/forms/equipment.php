<?php 
	include "../connect.php";
	

	$barcode = $_POST['inputBarcode'];
	$vendor_id = $_POST['inputVendorID'];
	$model = $_POST['inputModel'];
	$serial_num = $_POST['inputSerialNum'];
	$GFE_id = $_POST['inputGFEID'];
	$affiliated = $_POST['inputAffiliated'];
	$parent_rack_id = $_POST['inputParentRackID'];
	$elevation = $_POST['inputElevation'];
	$parent_equipment_id = $_POST['inputParentEquipmentID'];
	$comment = $_POST['inputComment'];

	$isempty = 0;

	

	if(isset($_POST[insert]))
	{
		$query = "INSERT INTO Equipment (BN_barcode_number, vendor_id, model, serial_num, GFE_id, affiliated, parent_rack_id, elevation, parent_equipment_id, comment) Values ('$barcode', $vendorI_id, '$model', $serial_num, '$GFE_id', '$affiliated', $parent_rack_id, $elevation, $parent_equipment_id, '$comment')";
		$q = $pdo->query($query);


	}


 ?>
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
						<form role="form" method="post" action="<?php echo $PHP_SELF; ?>">
							<div class="form-group">
								<label for="inputBarcode">Barcode Number</label>
								<input type="text" name="inputBarcode" class="form-control" id="inputBarcode" placeholder="Enter Barcode Number" maxlength="10" size="10">
							</div>
							<div class="form-group">
								<label for="inputVendorID">Vendor ID</label>
								<input type="text" class="form-control" id="inputVendorID" placeholder="Enter Vendor ID" maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputModel">Model</label>
								<input type="text" class="form-control" id="inputModel" placeholder="Enter Model" maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputSerialNum">Serial Number</label>
								<input type="text" class="form-control" id="inputSerialNum" placeholder="Enter Serial Number" maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputGFEID">GFE ID</label>
								<input type="text" class="form-control" id="inputGFEID" placeholder="Enter GFE ID" maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputAffiliated">Affiliated</label>
								<input type="text" class="form-control" id="inputAffiliated" placeholder="Enter Affiliation (R/E)" maxlength="1" size ="1">
							</div>
							<div class="form-group">
								<label for="inputParentRackID">Parent Rack ID</label>
								<input type="text" class="form-control" id="inputParentRackID" placeholder="Enter Parent Rack ID" maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputElevation">Elevation</label>
								<input type="text" class="form-control" id="inputElevation" placeholder="Enter Elevation" maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputParentEquipmentID">Parent Equipment ID</label>
								<input type="text" class="form-control" id="inputParentEquipmentID" placeholder="Enter Parent Equipment ID" maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputComment">Comments</label>
								<!--<input type="text" class="form-control" id="inputComment" placeholder="Enter Comments" maxlength="255" size ="255">-->
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
		<!-- Latest compiled and minified JavaScript -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
		<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"> </script>
	</body>
</html>