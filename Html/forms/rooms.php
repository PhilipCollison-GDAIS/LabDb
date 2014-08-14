<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";

class RoomsForm implements formsInterface{
	public function isInputValid(){
		if(empty($_POST['inputRoomNumber'])) {
			return "Please input a room number";
		}

		if(empty($_POST['inputBuildingName'])) {
			return "Please input a building name";
		}

		return true;
	}

	public function submit(){
		global $pdo;

		if(isset($_POST['insert']) /* && inputValidation */) {
			$query = "INSERT INTO rooms (room_number, building_name, comment) Values (:room_number, :building_name, :comment)";

			$wasSuccessful = $pdo->prepare($query)->execute(array(
				':room_number'=>$_POST['inputRoomNumber'],
				':building_name'=>$_POST['inputBuildingName'],
				':comment'=>$_POST['inputComment']));

			if ($wasSuccessful) {
				header('Location: /reports/rooms.php');
				exit;
			} else {
				// TODO: inform user
			}
		}
	}

	public function getTitle(){
		return 'Rooms';
	}

	public function getHeading(){
		return 'Rooms';
	}

	public function getFormString(){
		$string = '<form role="form" method="post" action="' . $_SERVER['PHP_SELF'] . '">';
		$string .= '<div class="form-group">';
		$string .= '<label for="inputRoomNumber">Room Number</label>';
		$string .= '<input type="text" name="inputRoomNumber" class="form-control" id="inputRoomNumber" placeholder="Enter Room Number" value="' . htmlspecialchars($_POST['inputRoomNumber']) . '" maxlength="10" size ="10" autofocus="autofocus">';
		$string .= '</div>';
		$string .= '<div class="form-group">';
		$string .= '<label for="inputBuildingName">Building Name</label>';
		$string .= '<input type="text" name="inputBuildingName" class="form-control" id="inputBuildingName" placeholder="Enter Room Number" value="' . htmlspecialchars($_POST['inputBuildingName']) . '" maxlength="45" size ="45" autofocus="autofocus">';
		$string .= '</div>';
		$string .= '<div class="form-group">';
		$string .= '<label for="inputComment">Comments</label>';
		$string .= '<textarea name="inputComment" class="form-control" id="inputComment" placeholder="Enter Optional Comments" cols="60" rows="4">' . stripslashes($_POST['inputComment']) . '</textarea>';
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

$form = new RoomsForm();

include "/inc/forms.php";
?>