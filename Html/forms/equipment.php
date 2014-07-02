<?php 
	require_once "/inc/connect.php";
	include "/inc/database.php";
	global $pdo;

	$barcode = $_POST['inputBarcode'];
	$vendor_id = $_POST['inputVendorID'];
	$model = $_POST['inputModel'];
	$serial_num = $_POST['inputSerialNum'];
	$GFE_id = $_POST['inputGFEID'];
	$comment = $_POST['inputComment'];

	$affiliationChar = $_POST['affiliationChar'];
	$parent_equipment_id = $_POST['parent_equipment_id'];
	$parent_rack_id = $_POST['parent_rack_id'];
	$elevation = $_POST['elevation'];

	function isEquipmentValid() {
		// global $barcode, $vendor_id, $model, $serial_num, $GFE_id;

		// if (!isShortAlNum($barcode)) {
		// 	$error_message = "barcode was invalid";
		// 	return false;
		// }

		// if (!isNumericInt($vendor_id)) {
		// 	$error_message = "vendor_id was invalid";
		// 	return false;
		// }

		// if (!isShortAlNum($model)) {
		// 	$error_message = "model was invalid";
		// 	return false;
		// }

		// if (!isNumericInt($serial_num)) {
		// 	$error_message = "serial_num was invalid";
		// 	return false;
		// }

		// if (!isShortAlNum($GFE_id)) {
		// 	$error_message = "GFE_id was invalid";
		// 	return false;
		// }

		// if ($affiliated === "R") {
		// 	if (isNumericInt($parent_rack_id) && isNumericInt($elevation)) {
		// 		return true;
		// 	} else {
		// 		$error_message = "Affiliation was invalid in Racks";
		// 		return false;
		// 	}
		// } else if ($affiliated === "E") {
		// 	if (isNumericInt($parent_equipment_id)) {
		// 		return true;
		// 	} else {
		// 		$error_message = "Affiliation was invalid in Equipment";
		// 		return false;
		// 	}
		// } else {
		// 	$error_message = "Affiliation was " . $affiliated;
		// 	return false;
		// }

		return false;
	}

	function isAffiliationValid() {
		return false;
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

	if (isset($_POST['submit']) && isEquipmentValid() && isAffiliationValid())
	{

		/* TODO: Insert both Equipment and its corresponding affiliation into the database.	*/

		// $parent_rack_id = $_POST['inputParentRackID'];
		// $elevation = $_POST['inputElevation'];

		// $query = "INSERT INTO Equipment (BN_barcode_number, vendor_id, affiliation_id, model, serial_num, GFE_id, comment) Values
		// (:barcode, :vendor_id, :affiliation_id, :model, :serial_num, :GFE_id, :comment)";

		// $q = $pdo->prepare($query);
		// $q->execute(array(':barcode'=>$barcode,
		// 				  ':vendor_id'=>$vendor_id,
		// 				  ':model'=>$model,
		// 				  ':serial_num'=>$serial_num,
		// 				  ':GFE_id'=>$GFE_id,
		// 				  ':comment'=>$comment));
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

					<h1>Equipment</h1>

					<?php
						if (!isset($_GET["affiliation"]) /* TODO: && !isEquipmentValid() */) {
							include "/inc/forms/equipment.php";
						} else { ?>

						<form role="form" method="post" action="/forms/equipment.php?affiliation">
							<div class="form-group">
								<label for="affiliationChar">Parent Affiliation:  </label>
								<select name="affiliationChar" onchange="this.form.submit();" <?php if(!isset($affiliationChar)) echo 'id="DropdownInitiallyBlank"' ?>>
									<option value="E" <?php if(isset($affiliationChar) && $affiliationChar == "E"){print "selected=\"selected\"";} ?>>Equipment</option>
									<option value="R" <?php if(isset($affiliationChar) && $affiliationChar == "R"){print "selected=\"selected\"";} ?>>Racks</option>
								</select>
							</div>
						</form>

					<?php } ?>


					<?php if(isset($affiliationChar) && ($affiliationChar === "R" || $affiliationChar === "E")){ ?>

						<form role="form" method="post" action="/forms/equipment.php?affiliation">

							<?php if($affiliationChar === "R"){ ?>

							<div class="form-group">
								<label for="parent_rack_id">Parent Rack</label>
								<select name="parent_rack_id" class="form-control">
									<?php echo getRackOptions(); ?>
								</select>
							</div>
							<div class="form-group">
								<label for="elevation">Elevation</label>
								<input type="text" name="elevation" class="form-control" id="elevation" placeholder="Enter Elevation" value="<?php if(isset($elevation)){ echo htmlspecialchars($elevation);} ?>"  maxlength="10" size="10">
							</div>




							<?php } else if ($affiliationChar === "E"){ ?>


							<div class="form-group">
								<label for="parent_equipment_id">Parent Equipment ID</label>
								<input type="text" name="parent_equipment_id" class="form-control" id="parent_equipment_id" placeholder="Enter Parent's Equipment ID" value="<?php if(isset($parent_equipment_id)){ echo htmlspecialchars($parent_equipment_id);} ?>"  maxlength="10" size="10">
							</div>



							<?php } else { ?>
								<?php echo '<p>$affiliationChar is invalid. It is currently "' . $affiliationChar . '" I am very confused.</p>' ?>
							<?php } ?>

							<div class="form-group">
								<label for="inputComment">Comments</label>
								<textarea name="inputComment" class="form-control" id="inputComment" placeholder="Enter Optional Comments" cols="60" rows="4"><?php if(isset($comment)){ echo stripslashes($comment);} ?></textarea>
							</div>

							<button type="submit" name="submit" class="btn btn-default">Submit</button>

						</form>

					<?php } ?>

					</div> <!--jumbotron-->
				</div>
				<div class="col-md-4"></div>
			</div>

		</div> <!-- /container -->

		<?php include "inc/footer.php" ?>

		<script type="text/javascript">document.getElementById("DropdownInitiallyBlank").selectedIndex = -1;</script>

	</body>
</html>