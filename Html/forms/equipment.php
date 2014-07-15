<?php
	require_once "/inc/connect.php";
	include "/inc/database.php";
	global $pdo;

	function isEquipmentValid() {
		$barcode = $_SESSION['barcode'];
		$vendor_id = $_SESSION['vendor_id'];
		$model = $_SESSION['model'];
		$serial_num = $_SESSION['serial_num'];
		$GFE_id = $_SESSION['GFE_id'];
		$comment = $_SESSION['comment'];

		if (!isset($barcode)) {
			return "Barcode must be set.";
		}

		if (!isset($vendor_id) || !isNumericInt($vendor_id)) {
			return "Please choose a vendor";
		}

		if (!isset($model)) {
			return "Model is not set.";
		}

		if (!isset($serial_num)) {
			return "Serial Number must be set.";
		}

		if (!isAlphaNumeric($barcode, 10)) {
			return "Barcode must be alphanumeric.";
		}

		if (!isAlphaNumeric($model, 10)) {
			return "Model must be alphanumeric.";
		}

		if (!isNumericInt($serial_num)) {
			return "Serial Number must be an integer.";
		}

		if (isset($GFE_id) && !ctype_alnum($GFE_id)) {
			return "GFE id must be alphanumeric.";
		}

		if (isset($comment) && !ctype_alnum($comment)) {
			return "Comment must be alphanumeric.";
		}

		return true;
	}

	function isAffiliationValid() {
		$parent_equipment_id = $_POST['parent_equipment_id'];
		$parent_rack_id = $_POST['parent_rack_id'];
		$elevation = $_POST['elevation'];

		if ($affiliated === "R") {
			if (!isNumericInt($parent_rack_id)){
				return "Please choose a rack.";
			}

			if (!isset($elevation)){
				return "Please input an elevation.";
			}

			if (!isNumericInt($elevation)) {
				return "Elevation must ba a number.";
			}
		} else if ($affiliated === "E") {
			if (!isNumericInt($parent_equipment_id)) {
				return "Please choose parent equipmet.";
			}
		} else {
			return "Please choose an affiliation.";
		}

		return true;
	}

	if (empty($_GET)) {
		unset($_SESSION['affiliated']);
	}

	if(isset($_GET["affiliation"])){
		// We only store the equipment properties on the initial load of affiliation
		// On any subsequent loads $_POST[affiliated] is set and we do not overwrite
		if(!isset($_POST['affiliated'])){
			$_SESSION['barcode'] = $_POST['inputBarcode'];
			$_SESSION['vendor_id'] = $_POST['inputVendorID'];
			$_SESSION['model'] = $_POST['inputModel'];
			$_SESSION['serial_num'] = $_POST['inputSerialNum'];
			$_SESSION['GFE_id'] = $_POST['inputGFEID'];
			$_SESSION['comment'] = $_POST['inputComment'];
		} else {
			$_SESSION['affiliated'] = $_POST['affiliated'];
			$affiliated = $_SESSION['affiliated'];
		}

	}

	$barcode = $_SESSION['barcode'];
	$vendor_id = $_SESSION['vendor_id'];
	$model = $_SESSION['model'];
	$serial_num = $_SESSION['serial_num'];
	$GFE_id = $_SESSION['GFE_id'];
	$comment = $_SESSION['comment'];

	$parent_equipment_id = $_POST['parent_equipment_id'];
	$parent_rack_id = $_POST['parent_rack_id'];
	$elevation = $_POST['elevation'];

	if (isset($_POST['insert']) /* && isEquipmentValid() === true && isAffiliationValid() === true */)
	{

		$affiliated = $_SESSION['affiliated'];

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
					echo 'Insertion of Equipment was NOT successful' . "\n";
					echo ' . ^ . ^ .' . "\n";
					print_r($q->errorInfo()) . "\n";
					echo ' . ^ . ^ .' . "\n";
					echo $q->errorCode() . "\n";
					echo ' . ^ . ^ .' . "\n";
				}

				// All was successful, clear session variables and redirect user
				unset($_SESSION['barcode']);
				unset($_SESSION['vendor_id']);
				unset($_SESSION['model']);
				unset($_SESSION['serial_num']);
				unset($_SESSION['GFE_id']);
				unset($_SESSION['comment']);
				unset($_SESSION['affiliated']);

				header('Location: /reports/equipment.php?id=' . $lastInsertId);
				exit;

			} else {
				echo '<pre>';
				echo 'Insertion of Affiliation was NOT successful' . "\n";
				echo ' . ^ . ^ .' . "\n";
				print_r($q->errorInfo()) . "\n";
				echo ' . ^ . ^ .' . "\n";
				echo $q->errorCode() . "\n";
				echo ' . ^ . ^ .' . "\n";
			}

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

					<?php if (!isset($_GET["affiliation"]) /* TODO: || isEquipmentValid() !== true */) { ?>

						<form role="form" method="post" action="/forms/equipment.php?affiliation">

							<div class="form-group">
								<label for="inputSerialNum">Serial Number</label>
								<input type="text" name="inputSerialNum" class="form-control" id="inputSerialNum" placeholder="Enter Serial Number" value="<?php if(isset($serial_num)){ echo htmlspecialchars($serial_num);} ?>"  maxlength="10" size ="10">
							</div>

							<div class="form-group">
								<label for="inputName">Name (Optional)</label>
								<input type="text" name="inputName" class="form-control" id="inputName" placeholder="Enter Optional Name" value="<?php if(isset($model)){ echo htmlspecialchars($model);} ?>"  maxlength="10" size ="10">
							</div>

							<div class="form-group">
								<label for="inputBarcode">Barcode Number</label>
								<input type="text" name="inputBarcode" class="form-control" id="inputBarcode" placeholder="Enter Barcode Number" value="<?php if(isset($barcode)){ echo htmlspecialchars($barcode);} ?>"  maxlength="10" size="10" autofocus="autofocus">
							</div>

							<div class="form-group">
								<label for="inputVendorID">Vendor</label>
								<select name="inputVendorID" class="form-control DropdownInitiallyBlank">
									<?php echo getVendorOptions(); ?>
								</select>
							</div>

							<div class="form-group">
								<label for="inputModel">Model</label>
								<input type="text" name="inputModel" class="form-control" id="inputModel" placeholder="Enter Model" value="<?php if(isset($model)){ echo htmlspecialchars($model);} ?>"  maxlength="10" size ="10">
							</div>

							<div class="form-group">
								<label for="inputGFEID">GFE ID (Optional)</label>
								<input type="text" name="inputGFEID" class="form-control" id="inputGFEID" placeholder="Enter GFE ID" value="<?php if(isset($GFE_id)){ echo htmlspecialchars($GFE_id);} ?>"  maxlength="10" size ="10">
							</div>

							<div class="form-group">
								<label for="inputComment">Comments</label>
								<textarea name="inputComment" class="form-control" id="inputComment" placeholder="Enter Optional Comments" cols="60" rows="4"><?php if(isset($comment)){ echo stripslashes($comment);} ?></textarea>
							</div>

							<button type="submit" name="next" class="btn btn-default">Next</button>
						</form>

					<?php } else { ?>

						<form role="form" method="post" action="/forms/equipment.php?affiliation">
							<div class="form-group">
								<label for="affiliated">Are you located on a rack or in a piece of equipment:  </label>
								<select name="affiliated" onchange="this.form.submit();" <?php if(!isset($affiliated)) echo 'class="DropdownInitiallyBlank"' ?>>
									<option value="E" <?php if(isset($affiliated) && $affiliated == "E"){print "selected=\"selected\"";} ?>>Equipment</option>
									<option value="R" <?php if(isset($affiliated) && $affiliated == "R"){print "selected=\"selected\"";} ?>>Racks</option>
								</select>
							</div>
						</form>

					<?php } ?>


					<?php if(isset($affiliated) && ($affiliated === "R" || $affiliated === "E")){ ?>

						<form role="form" method="post" action="/forms/equipment.php?submit">

							<?php if($affiliated === "R"){ ?>

							<div class="form-group">
								<label for="parent_rack_id">Parent Rack</label>
								<select name="parent_rack_id" class="form-control DropdownInitiallyBlank">
									<?php echo getRackOptions(); ?>
								</select>
							</div>
							<div class="form-group">
								<label for="elevation">Elevation</label>
								<input type="text" name="elevation" class="form-control" id="elevation" placeholder="Enter Elevation" value="<?php if(isset($elevation)){ echo htmlspecialchars($elevation);} ?>"  maxlength="10" size="10">
							</div>

							<?php } else if ($affiliated === "E"){ ?>


							<div class="form-group">
								<label for="parent_equipment_id">Parent Equipment ID</label>
								<input type="text" name="parent_equipment_id" class="form-control" id="parent_equipment_id" placeholder="Enter Parent's Equipment ID" value="<?php if(isset($parent_equipment_id)){ echo htmlspecialchars($parent_equipment_id);} ?>"  maxlength="10" size="10">
							</div>

							<?php } else { ?>
								<?php echo '<p>$affiliated is invalid. It is currently "' . $affiliated . '". I am very confused; this can literally never be called!</p>' ?>
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

	</body>
</html>