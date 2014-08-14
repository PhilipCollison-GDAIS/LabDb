<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";

class VendorsForm implements formsInterface{
	public function isInputValid(){
		if(empty($_POST['inputVendor'])) {
			return "Please input a vendor";
		}

		return true;
	}

	public function submit(){
		global $pdo;

		$query = "INSERT INTO vendors (vendor, comment) Values (:vendor, :comment)";

		$wasSuccessful = $pdo->prepare($query)->execute(array(':vendor'=>$_POST['inputVendor'], ':comment'=>$_POST['inputComment']));

		if ($wasSuccessful) {
			header('Location: /reports/vendors.php');
			exit;
		} else {
			return "Insertion was Unsuccessful: Error code is " . $q->errorCode();
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

		$string = '<form role="form" method="post" action="' . $_SERVER['PHP_SELF'] . '">';
		$string .= '<div class="form-group">';
		$string .= '<label for="inputVendor">Vendor</label>';
		$string .= '<input type="text" name="inputVendor" class="form-control" id="inputVendor" placeholder="Enter Vendor" maxlength="20" size ="20" value="' . htmlspecialchars($vendor) . '" autofocus="autofocus">';
		$string .= '</div>';
		$string .= '<div class="form-group">';
		$string .= '<label for="inputComment">Comments</label>';
		$string .= '<textarea name="inputComment" class="form-control" id="inputComment" placeholder="Enter Optional Comments" cols="60" rows="4">' . stripslashes($comment) . '</textarea>';
		$string .= '</div>';
		$string .= '<button type="submit" name="insert" class="btn btn-default">Insert</button>';
		$string .= '</form>';

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

$form = new VendorsForm();

include "/inc/forms.php";
?>