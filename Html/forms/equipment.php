<?php 
	include "/inc/connect.php";
	global $pdo;

	$barcode = $_POST['inputBarcode'];
	$vendor_id = $_POST['inputVendorID'];
	$model = $_POST['inputModel'];
	$serial_num = $_POST['inputSerialNum'];
	$GFE_id = $_POST['inputGFEID'];
	$affiliated = $_POST['inputAffiliation'];
	$parent_rack_id = NULL;
	$elevation = NULL;
	$parent_equipment_id = NULL;
	$comment = $_POST['inputComment'];

	function isValid() {
		global $barcode, $vendor_id, $model, $serial_num, $GFE_id, $affiliated, $parent_rack_id, $elevation, $parent_equipment_id, $error_message;

		if (!isShortAlNum($barcode)) {
			$error_message = "barcode was invalid";
			return false;
		}

		if (!isNumericInt($vendor_id)) {
			$error_message = "vendor_id was invalid";
			return false;
		}

		if (!isShortAlNum($model)) {
			$error_message = "model was invalid";
			return false;
		}

		if (!isNumericInt($serial_num)) {
			$error_message = "serial_num was invalid";
			return false;
		}

		if (!isShortAlNum($GFE_id)) {
			$error_message = "GFE_id was invalid";
			return false;
		}

		if ($affiliated === "R") {
			if (isNumericInt($parent_rack_id) && isNumericInt($elevation)) {
				return true;
			} else {
				$error_message = "Affiliation was invalid in Racks";
				return false;
			}
		} else if ($affiliated === "E") {
			if (isNumericInt($parent_equipment_id)) {
				return true;
			} else {
				$error_message = "Affiliation was invalid in Equipment";
				return false;
			}
		} else {
			$error_message = "Affiliation was " . $affiliated;
			return false;		
		}
	}

	function isNumericInt($x) {
		global $specific_error;

		if (empty($x)) {
			$specific_error = "was empty!\n";
			return false;
		}

		if (!is_numeric($x)) {
			$specific_error = "was not numeric!\n";
			return false;
		}

		if (!($x > 0 && $x == round($x))) {
			$specific_error = "was not a positive int!\n";
			return false;
		}

		return true;
	}

	function isShortAlNum($x) {
		global $specific_error;

		if (empty($x)) {
			$specific_error = "was empty!\n";
			return false;
		}

		if (strlen($x) > 10) {
			$specific_error = "was too long!\n";
			return false;
		}

		if (!ctype_alnum($x)) {
			$specific_error = "was not alpha-numeric!\n";
			return false;
		}

		return true;
	}
	
	/*
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
	*/

	if (isset($_POST[insert]) && isValid())
	{

		if ($affiliated === "E") {
			$parent_rack_id = $_POST['inputParentRackID'];
			$elevation = $_POST['inputElevation'];

			$query = "INSERT INTO Equipment (BN_barcode_number, vendor_id, model, serial_num, GFE_id, affiliated, parent_rack_id, elevation, parent_equipment_id, comment) Values
			(:barcode, :vendor_id, :model, :serial_num, :GFE_id, :affiliated, :parent_rack_id, :elevation, :parent_equipment_id, :comment)";

			$q = $pdo->prepare($query);
			$q->execute(array(':barcode'=>$barcode,
							  ':vendor_id'=>$vendor_id,
							  ':model'=>$model,
							  ':serial_num'=>$serial_num,
							  ':GFE_id'=>$GFE_id,
							  ':affiliated'=>$affiliated,
							  ':parent_rack_id'=>$parent_rack_id,
							  ':elevation'=>$elevation,
							  ':parent_equipment_id'=>NULL,
							  ':comment'=>$comment));

		} else if ($affiliated === "R") {
			$parent_equipment_id = $_POST['inputParentEquipmentID'];

			$query = "INSERT INTO Equipment (BN_barcode_number, vendor_id, model, serial_num, GFE_id, affiliated, parent_rack_id, elevation, parent_equipment_id, comment) Values
			(:barcode, :vendor_id, :model, :serial_num, :GFE_id, :affiliated, :parent_rack_id, :elevation, :parent_equipment_id, :comment)";

			$q = $pdo->prepare($query);
			$q->execute(array(':barcode'=>$barcode,
							  ':vendor_id'=>$vendor_id,
							  ':model'=>$model,
							  ':serial_num'=>$serial_num,
							  ':GFE_id'=>$GFE_id,
							  ':affiliated'=>$affiliated,
							  ':parent_rack_id'=>NULL,
							  ':elevation'=>NULL,
							  ':parent_equipment_id'=>$parent_equipment_id,
							  ':comment'=>$comment));

		}

	}


 ?>
<!DOCTYPE html>
<html lang="en">
	<head>
	    <?php include "/inc/header.php" ?>

		<title>Equipment</title>
	</head>

	<body onload='hideBoth()'>
		<div class="container">
			
			<?php include "/inc/navbar.php" ?>
		
			
			<div class="row">
				<?php include "/inc/sidebar.php" ?>

				<div class="col-md-10">
					<div class="jumbotron">
						<form role="form" method="post" action="<?php echo $PHP_SELF; ?>">
							<div class="form-group">
								<label for="inputBarcode">Barcode Number</label>
								<input type="text" name="inputBarcode" class="form-control" id="inputBarcode" placeholder="Enter Barcode Number" maxlength="10" size="10" autofocus="autofocus">
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
								<input type="text" name="inputParentEquipmentID" class="form-control" id="inputParentEquipmentID" placeholder="Enter Parent Equipment ID" maxlength="10" size ="10">
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

		<?php include "inc/footer.php" ?>

		<script>
			function hideBoth() {
				document.getElementById("inputParentRackID").style.visibility="hidden";
				document.getElementById("inputParentRackIDLabel").style.visibility="hidden";
				document.getElementById("inputElevation").style.visibility="hidden";
				document.getElementById("inputElevationLabel").style.visibility="hidden";
				document.getElementById("inputParentEquipmentID").style.visibility="hidden";
				document.getElementById("inputParentEquipmentIDLabel").style.visibility="hidden";
			}

			function hola(x) {
				hideBoth();

				if (x==1)
				{
					<?php $affiliated = "R"; ?>
					document.getElementById("inputParentRackID").style.visibility="visible";
					document.getElementById("inputParentRackIDLabel").style.visibility="visible";
					document.getElementById("inputElevation").style.visibility="visible";
					document.getElementById("inputElevationLabel").style.visibility="visible";
				}
				else if (x==2)
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