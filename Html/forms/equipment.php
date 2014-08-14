<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";
include "/inc/database.php";

class EquipmentForm implements formsInterface{
	public function isInputValid(){
		$barcode = $_POST['inputBarcode'];
		$vendor_id = $_POST['inputVendor'];
		$model = $_POST['inputModel'];
		$serial_num = $_POST['inputSerialNum'];
		$GFE_id = $_POST['inputGFEID'];
		$comment = $_POST['inputComment'];

		if (empty($serial_num)) {
			return "Serial Number must be set.";
		}

		if (!isNaturalNumber($serial_num)) {
			return "Serial Number must be an integer.";
		}

		if (empty($barcode)) {
			return "Barcode must be set.";
		}

		if (!isAlphaNumeric($barcode, 10)) {
			return "Barcode must be alphanumeric.";
		}

		if (empty($vendor_id) || !isNaturalNumber($vendor_id)) {
			return "Please choose a vendor";
		}

		if (empty($model)) {
			return "Model is not set.";
		}

		if (!isAlphaNumeric($model, 10)) {
			return "Model must be alphanumeric.";
		}

		if (isset($GFE_id) && !ctype_alnum($GFE_id)) {
			return "GFE id must be alphanumeric.";
		}

		$parent_equipment_id = $_POST['parent_equipment_id'];
		$parent_rack_id = $_POST['inputParentRackID'];
		$elevation = $_POST['inputElevation'];

		/* TODO: AJAX */
		// if ($affiliated === "R") {
			if (!isNaturalNumber($parent_rack_id)){
				return "Please choose a rack.";
			}

			if (empty($elevation)){
				return "Please input an elevation.";
			}

			if (!isNaturalNumber($elevation)) {
				return "Elevation must ba a number.";
			}
		// } else if ($affiliated === "E") {
		// 	if (!isNaturalNumber($parent_equipment_id)) {
		// 		return "Please choose parent equipment.";
		// 	}
		// } else {
		// 	return "Please choose an affiliation.";
		// }

		return true;
	}

	public function submit(){
		global $pdo;

		$barcode = $_POST['inputBarcode'];
		$vendor_id = $_POST['inputVendor'];
		$model = $_POST['inputModel'];
		$serial_num = $_POST['inputSerialNum'];
		$GFE_id = $_POST['inputGFEID'];
		$comment = $_POST['inputComment'];

		$parent_equipment_id = $_POST['parent_equipment_id'];
		$parent_rack_id = $_POST['inputParentRackID'];
		$elevation = $_POST['inputElevation'];

		if (isset($_POST['insert']))
		{

			$affiliated = "R"; // TODO:

			try{
				// Insert affiliation
				$query = "INSERT INTO affiliations (affiliated, parent_equipment_id, parent_rack_id, elevation) VALUES
				(:affiliated, :parent_equipment_id, :parent_rack_id, :elevation)";

				$q = $pdo->prepare($query);
				$wasSuccessful = $q->execute(array(':affiliated'=>$affiliated,
								  ':parent_equipment_id'=>$parent_equipment_id,
								  ':parent_rack_id'=>$parent_rack_id,
								  ':elevation'=>$_POST['inputElevation']));

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
						header('Location: /reports/equipment.php?id=' . $lastInsertId);
						exit;
					} else {
						echo '<pre>';
						echo 'Insertion of Equipment was NOT successful' . "\n";
						echo ' . ^ . ^ .' . "\n";
						print_r($q->errorInfo()) . "\n";
						echo ' . ^ . ^ .' . "\n";
						echo $q->errorCode() . "\n";
						echo ' . ^ . ^ .' . "\n";
						echo '</pre>';
					}
				} else {
					echo '<pre>';
					echo 'Insertion of Affiliation was NOT successful' . "\n";
					echo ' . ^ . ^ .' . "\n";
					print_r($q->errorInfo()) . "\n";
					echo ' . ^ . ^ .' . "\n";
					echo $q->errorCode() . "\n";
					echo ' . ^ . ^ .' . "\n";
					echo '</pre>';
				}
			} catch (Exception $e) {
				echo 'Caught exception: ', $e->getMessage(), "\n";
			}

		}
	}

	public function getTitle(){
		return 'Equipment';
	}

	public function getHeading(){
		return 'Equipment';
	}

	public function getFormString(){
		// $string .= '<?php if (!isset($_GET["affiliation"]) /* TODO: || isEquipmentValid() !== true */) {

		$string .= '<form role="form" method="post" action="' . $_SERVER['PHP_SELF'] . '">';

		$string .= '<div class="form-group">';
		$string .= '<label for="inputSerialNum">Serial Number</label>';
		$string .= '<input type="text" name="inputSerialNum" class="form-control" id="inputSerialNum" placeholder="Enter Serial Number" value="' . htmlspecialchars($_POST['inputSerialNum']) . '"  maxlength="10" size ="10" autofocus="autofocus">';
		$string .= '</div>';

		$string .= '<div class="form-group">';
		$string .= '<label for="inputName">Name (Optional)</label>';
		$string .= '<input type="text" name="inputName" class="form-control" id="inputName" placeholder="Enter Optional Name" value="' . htmlspecialchars($_POST['inputName']) . '"  maxlength="10" size ="10">';
		$string .= '</div>';

		$string .= '<div class="form-group">';
		$string .= '<label for="inputBarcode">Barcode Number</label>';
		$string .= '<input type="text" name="inputBarcode" class="form-control" id="inputBarcode" placeholder="Enter Barcode Number" value="' . htmlspecialchars($_POST['inputBarcode']) . '"  maxlength="10" size="10">';
		$string .= '</div>';

		$string .= '<div class="form-group">';
		$string .= '<label for="inputVendor">Vendor</label>';
		$string .= '<select name="inputVendor" class="form-control">';
		$string .= getVendorOptions($_POST['inputVendor']);
		$string .= '</select>';
		$string .= '</div>';

		$string .= '<div class="form-group">';
		$string .= '<label for="inputModel">Model</label>';
		$string .= '<input type="text" name="inputModel" class="form-control" id="inputModel" placeholder="Enter Model" value="' . htmlspecialchars($_POST['inputModel']) . '"  maxlength="10" size ="10">';
		$string .= '</div>';

		$string .= '<div class="form-group">';
		$string .= '<label for="inputGFEID">GFE ID (Optional)</label>';
		$string .= '<input type="text" name="inputGFEID" class="form-control" id="inputGFEID" placeholder="Enter GFE ID" value="' . htmlspecialchars($_POST['inputGFEID']) . '"  maxlength="10" size ="10">';
		$string .= '</div>';

		$string .= '<div class="form-group">';
		$string .= '<label for="inputComment">Comments</label>';
		$string .= '<textarea name="inputComment" class="form-control" id="inputComment" placeholder="Enter Optional Comments" cols="60" rows="4">' . stripslashes($_POST['inputComment']) . '</textarea>';
		$string .= '</div>';

		$string .= '<div class="form-group" style="display:none">';
		$string .= '<label for="affiliated">Are you located on a rack or in a piece of equipment:  </label>';
		$string .= '<select name="affiliated" class="form-control">'; // TODO: AJAX HERE!
		// $string .= '<option></option>';
		// $string .= '<option value="E"';
		// if (isset($affiliated) && $affiliated === "E") { $string .= ' selected="selected"'; }
		// $string .= '>Equipment</option>';
		$string .= '<option value="R"';
		// if (isset($affiliated) && $affiliated === "R") {
		$string .= ' selected="selected"';
		// }
		$string .= '>Racks</option>';
		$string .= '</select>';
		$string .= '</div>';

		// $string .= '<?php }

		// $string .= '<?php if(isset($affiliated) && ($affiliated === "R" || $affiliated === "E")){

		// $string .= '<?php if($affiliated === "R"){

		echo '<pre>';
		var_dump($_POST);
		echo '</pre>';

		$string .= '<div class="form-group">';
		$string .= '<label for="inputParentRackID">Parent Rack</label>';
		$string .= '<select name="inputParentRackID" class="form-control">';
		$string .= getRackOptions($_POST['inputParentRackID']);
		$string .= '</select>';
		$string .= '</div>';
		$string .= '<div class="form-group">';
		$string .= '<label for="inputElevation">Elevation</label>';
		$string .= '<input type="text" name="inputElevation" class="form-control" id="inputElevation" placeholder="Enter Elevation" value="' . htmlspecialchars($_POST['inputElevation']) . '"  maxlength="10" size="10">';
		$string .= '</div>';

		// $string .= '<?php } else if ($affiliated === "E"){

		// $string .= '<div class="form-group">';
		// $string .= '<label for="parent_equipment_id">Parent Equipment ID</label>';
		// $string .= '<input type="text" name="parent_equipment_id" class="form-control" id="parent_equipment_id" placeholder="Enter Parent\'s Equipment ID" value="' . htmlspecialchars($parent_equipment_id) . '"  maxlength="10" size="10">';
		// $string .= '</div>';

		// $string .= '<?php } else {
		// $string .= '<p>$affiliated is invalid. It is currently ' . $affiliated . '. I am very confused; this can literally never be called!</p>';
		// $string .= '<?php }

		$string .= '<button type="submit" name="insert" class="btn btn-default">Insert</button>';

		$string .= '</form>';

		// $string .= '<?php }

		return $string;
	}

	public function getEditString($id){
		echo '<script>window.location = "' . strtok($_SERVER['REQUEST_URI'], '?') . '";</script>';
		exit;
	}

	public function getCopyString($id){
		echo '<script>window.location = "' . strtok($_SERVER['REQUEST_URI'], '?') . '";</script>';
		exit;
	}
}

$form = new EquipmentForm();

include "/inc/forms.php";
