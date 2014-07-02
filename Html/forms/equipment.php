<?php
	require_once "/inc/connect.php";
	include "/inc/database.php";
	global $pdo;

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

	if(isset($_GET["affiliation"])){
		// We only store the equipment properties on the initial load of affiliation
		// On any subsequent loads $_POST[affiliationChar] is set and we do not overwrite
		if(!isset($_POST['affiliationChar'])){
			echo "Overloading SESSION!!!";
			$_SESSION['barcode'] = $_POST['inputBarcode'];
			$_SESSION['vendor_id'] = $_POST['inputVendorID'];
			$_SESSION['model'] = $_POST['inputModel'];
			$_SESSION['serial_num'] = $_POST['inputSerialNum'];
			$_SESSION['GFE_id'] = $_POST['inputGFEID'];
			$_SESSION['comment'] = $_POST['inputComment'];
		} else {
			echo "Not overloading SESSION";
			$_SESSION['affiliationChar'] = $_POST['affiliationChar'];
		}

		$affiliationChar = $_SESSION['affiliationChar'];
	}

	if (isset($_POST['insert']) /* && isEquipmentValid() && isAffiliationValid() */)
	{

		$barcode = $_SESSION['barcode'];
		$vendor_id = $_SESSION['vendor_id'];
		$model = $_SESSION['model'];
		$serial_num = $_SESSION['serial_num'];
		$GFE_id = $_SESSION['GFE_id'];
		$comment = $_SESSION['comment'];

		$affiliated = $_SESSION['affiliationChar'];
		$parent_equipment_id = $_POST['parent_equipment_id'];
		$parent_rack_id = $_POST['parent_rack_id'];
		$elevation = $_POST['elevation'];

		try{
			// Insert affiliation
			$query = "INSERT INTO affiliations (affiliated, parent_equipment_id, parent_rack_id, elevation) VALUES
			(:affiliated, :parent_equipment_id, :parent_rack_id, :elevation)";

			$q = $pdo->prepare($query);
			$wasSuccessful = $q->execute(array(':affiliated'=>$affiliated,
							  ':parent_equipment_id'=>$parent_equipment_id,
							  ':parent_rack_id'=>$parent_rack_id,
							  ':elevation'=>$elevation));

			if($wasSuccessful){
				//Insertion of Affiliation was successful";
			} else {
				echo '<pre>';
				echo 'Insertion of Affiliation was NOT successful\n';
				echo ' . ^ . ^ .';
				print_r($q->errorInfo());
				echo ' . ^ . ^ .';
				echo $q->errorCode();
				echo ' . ^ . ^ .';
				exit;
			}

			// Find and store lastInsertId
			$lastInsertId = $pdo->lastInsertId();

			// Insert piece of equipment with lastInsertId as id/pk
			$query = "INSERT INTO equipment (id, barcode_number, vendor_id, model, serial_num, GFE_id, comment) VALUES
			(:id, :barcode, :vendor_id, :model, :serial_num, :GFE_id, :comment)";

			$q = $pdo->prepare($query);
			$wasSuccessful = $q->execute(array(':id'=>$lastInsertId,
							  ':barcode'=>$barcode,
							  ':vendor_id'=>$vendor_id,
							  ':model'=>$model,
							  ':serial_num'=>$serial_num,
							  ':GFE_id'=>$GFE_id,
							  ':comment'=>$comment));

			if($wasSuccessful){
				echo "Insertion of Equipment was successful";
			} else {
				echo '<pre>';
				echo 'Insertion of Affiliation was NOT successful\n';
				echo ' . ^ . ^ .';
				print_r($q->errorInfo());
				echo ' . ^ . ^ .';
				echo $q->errorCode();
				echo ' . ^ . ^ .';
				exit;
			}

			// All was successful, cear session variables and redirect user
			unset($_SESSION['barcode']);
			unset($_SESSION['vendor_id']);
			unset($_SESSION['model']);
			unset($_SESSION['serial_num']);
			unset($_SESSION['GFE_id']);
			unset($_SESSION['comment']);
			unset($_SESSION['affiliationChar']);

			header('Location: /reports/equipment.php?id=' . $lastInsertId);


		} catch (Exception $e) {
			echo 'Caught exception: ', $e->getMessage(), "\n";
		}

	}

	// echo '<pre>';

	// var_dump($_SESSION) . "\n";

	// echo '</pre>';

	// echo '<pre>';

	// echo "barcode: $barcode\n";
	// echo "vendor id: $vendor_id\n";
	// echo "model: $model\n";
	// echo "serial_num: $serial_num\n";
	// echo "GFE_id: $GFE_id\n";
	// echo "affiliated: $affiliated\n";
	// echo "parent_rack_id: $parent_rack_id\n";
	// echo "elevation: $elevation\n";
	// echo "parent_equipment_id: $parent_equipment_id\n";
	// echo "comment: $comment\n";

	// echo '</pre>';

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

						<form role="form" method="post" action="/forms/equipment.php?submit">

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
								<?php echo '<p>$affiliationChar is invalid. It is currently "' . $affiliationChar . '" I am very confused; this can literally never be called!</p>' ?>
							<?php } ?>

							<button type="submit" name="insert" class="btn btn-default">Insert</button>

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