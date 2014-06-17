<?php 
	include "../connect.php";
	

	$barcode = $_POST['inputBarcode'];
	$vendor_id = $_POST['inputVendorID'];
	$model = $_POST['inputModel'];
	$serial_num = $_POST['inputSerialNum'];
	$GFE_id = $_POST['inputGFEID'];
	$affiliated = $_POST['inputAffiliation'];
	$parent_rack_id = $_POST['inputParentRackID'];
	$elevation = $_POST['inputElevation'];
	$parent_equipment_id = $_POST['inputParentEquipmentID'];
	$comment = $_POST['inputComment'];

	$isempty = 0;

	echo "barcode: $barcode";
	echo "vendor id: $vendor_id";
	echo "model: $model";
	echo "serial_num: $serial_num";
	echo "GFE_id: $GFE_id";
	echo "affiliated: $affiliated";
	echo "parent_rack_id: $parent_rack_id";
	echo "elevation: $elevation";
	echo "parent_equipment_id: $parent_equipment_id";
	echo "comment: $comment";

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

	<body onload='hideBoth()'>
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
								<input type="text" name="inputVendorID" class="form-control" id="inputVendorID" placeholder="Enter Vendor ID" maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputModel">Model</label>
								<input type="text" name="inputModel" class="form-control" id="inputModel" placeholder="Enter Model" maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputSerialNum">Serial Number</label>
								<input type="text" name="inputSerialNum" class="form-control" id="inputSerialNum" placeholder="Enter Serial Number" maxlength="10" size ="10">
							</div>
							<div class="form-group">
								<label for="inputGFEID">GFE ID</label>
								<input type="text" name="inputGFEID" class="form-control" id="inputGFEID" placeholder="Enter GFE ID" maxlength="10" size ="10">
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="inputAffiliation" id="inputAffiliated" value="R" onclick="hola(1)">
									Rack
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="inputAffiliation" id="inputAffiliated" value="E" onclick="hola(2)">
									Equipment
								</label>
							</div>
							<div class="form-group" style="visibility:hidden">
								<label id="inputParentRackIDLabel" for="inputParentRackID">Parent Rack ID</label>
								<input type="text" name="inputParentRackID" class="form-control" id="inputParentRackID" placeholder="Enter Parent Rack ID" maxlength="10" size ="10">
							</div>
							<div class="form-group" style="visibility:hidden">
								<label id="inputElevationLabel" for="inputElevation">Elevation</label>
								<input type="text" name="inputElevation" class="form-control" id="inputElevation" placeholder="Enter Elevation" maxlength="10" size ="10">
							</div>
							<div class="form-group" style="visibility:hidden">
								<label id="inputParentEquipmentIDLabel" for="inputParentEquipmentID">Parent Equipment ID</label>
								<input type="text" name="inputParentEquipmentId" class="form-control" id="inputParentEquipmentID" placeholder="Enter Parent Equipment ID" maxlength="10" size ="10">
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
		<!-- Latest compiled and minified JavaScript 
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>-->
		<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"> </script>
		<script src="http://getbootstrap.com/assets/js/docs.min.js"></script>
		<script>
			function hideBoth(){
				document.getElementById("inputParentRackID").style.visibility="hidden";
				document.getElementById("inputParentRackIDLabel").style.visibility="hidden";
				document.getElementById("inputElevation").style.visibility="hidden";
				document.getElementById("inputElevationLabel").style.visibility="hidden";
				document.getElementById("inputParentEquipmentID").style.visibility="hidden";
				document.getElementById("inputParentEquipmentIDLabel").style.visibility="hidden";

				document.getElementById("inputParentRackID").value = '';
				document.getElementById("inputElevation").value = '';
				document.getElementById("inputParentEquipmentID").value = '';
			}

			function hola(x){
				hideBoth();

				if(x==1)
				{
					<?php $affiliated = "R"; ?>
					document.getElementById("inputParentRackID").style.visibility="visible";
					document.getElementById("inputParentRackIDLabel").style.visibility="visible";
					document.getElementById("inputElevation").style.visibility="visible";
					document.getElementById("inputElevationLabel").style.visibility="visible";
				}
				else if(x==2)
				{
					<?php $affiliated = "E"; ?>
					$affiliated = "F";
					document.getElementById("inputParentEquipmentID").style.visibility="visible";
					document.getElementById("inputParentEquipmentIDLabel").style.visibility="visible";
				}
			}
		</script>
	</body>
</html>