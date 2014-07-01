<?php 
	include "/inc/connect.php";
	global $pdo;

	$barcode = $_POST['inputBarcode'];
	$vendor_id = $_POST['inputVendorID'];
	$model = $_POST['inputModel'];
	$serial_num = $_POST['inputSerialNum'];
	$GFE_id = $_POST['inputGFEID'];
	// $affiliated = $_POST['inputAffiliation'];
	// $parent_rack_id = NULL;
	// $elevation = NULL;
	// $parent_equipment_id = NULL;
	$comment = $_POST['inputComment'];

	function isValid() {
		global $barcode, $vendor_id, $model, $serial_num, $GFE_id, $error_message;

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

	if (isset($_POST[insert]))
	{

		$parent_rack_id = $_POST['inputParentRackID'];
		$elevation = $_POST['inputElevation'];

		$query = "INSERT INTO Equipment (BN_barcode_number, vendor_id, affiliation_id, model, serial_num, GFE_id, comment) Values
		(:barcode, :vendor_id, :affiliation_id, :model, :serial_num, :GFE_id, :comment)";

		$q = $pdo->prepare($query);
		$q->execute(array(':barcode'=>$barcode,
						  ':vendor_id'=>$vendor_id,
						  ':model'=>$model,
						  ':serial_num'=>$serial_num,
						  ':GFE_id'=>$GFE_id,
						  ':comment'=>$comment));
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
						if (!isset($_GET["affiliation"])) {
							include "/inc/forms/equipment.php";
						} else { ?>



					<?php } ?>
					</div> <!--jumbotron-->
				</div>
				<div class="col-md-4"></div>
			</div>

		</div> <!-- /container -->

		<?php include "inc/footer.php" ?>

	</body>
</html>