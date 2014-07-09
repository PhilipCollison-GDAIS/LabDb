<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";

class VendorsForm implements formsInterface{
	public function submit(){
		global $pdo;

		$vendor = $_POST['inputVendor'];
		$comment = $_POST['inputComment'];

		if(isset($_POST['insert']) /* && inputValidation */) {
			$query = "INSERT INTO vendors (vendor, comment) Values (:vendor, :comment)";

			$wasSuccessful = $pdo->prepare($query)->execute(array(':vendor'=>$vendor, ':comment'=>$comment));

			if ($wasSuccessful) {
				header('Location: /reports/vendors.php');
				exit;
			} else {
				// TODO: inform user
			}
		}
	}

	public function getTitle(){
		return 'Vendors';
	}

	public function getHeading(){
		return 'Vendors';
	}

	public function getFormString(){
		$vendor = $_POST['inputVendor'];
		$comment = $_POST['inputComment'];

		$string .= '<form role="form" method="post" action="' . $_SERVER['PHP_SELF'] . '">';
		$string .= '<div class="form-group">';
		$string .= '<label for="inputVendor">Vendor</label>';
		$string .= '<input type="text" name="inputVendor" class="form-control" id="inputVendor" placeholder="Enter Vendor" maxlength="20" size ="20"'; 
		if(isset($vendor)){ $string.= 'value="' . htmlspecialchars($vendor);} '"';
		$string .= 'autofocus="autofocus">';
		$string .= '</div>';
		$string .= '<div class="form-group">';
		$string .= '<label for="inputComment">Comments</label>';
		$string .= '<textarea name="inputComment" class="form-control" id="inputComment" placeholder="Enter Optional Comments" cols="60" rows="4">';
		if(isset($comment)){ $string .= stripslashes($comment);}
		$string .= '</textarea>';
		$string .= '</div>';
		$string .= '<button type="submit" name="insert" class="btn btn-default">Insert</button>';
		$string .= '</form>';


		return $string;
	}

	public function getEditString($id){
		throw new Exception('Unimplemented Function');
	}

	public function getCopyString($id){
		throw new Exception('Unimplemented Function');
	}
}

$form = new VendorsForm();

include "/inc/forms.php";
?>