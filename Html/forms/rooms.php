<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";

class RoomsForm implements formsInterface{
	public function submit(){
		global $pdo;

		$room_number = $_POST['inputRoomNumber'];
		$comment = $_POST['inputComment'];

		if(isset($_POST['insert']) /* && inputValidation */) {
			$query = "INSERT INTO rooms (room_number, comment) Values (:room_number, :comment)";

			$wasSuccessful = $pdo->prepare($query)->execute(array(':room_number'=>$room_number, ':comment'=>$comment));

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
		$room_number = $_POST['inputRoomNumber'];
		$comment = $_POST['inputComment'];

		$string = '<form role="form" method="post" action="' . $_SERVER['PHP_SELF'] . '">';
		$string .= '<div class="form-group">';
		$string .= '<label for="inputRoomNumber">Room Number</label>';
		$string .= '<input type="text" name="inputRoomNumber" class="form-control" id="inputRoomNumber" placeholder="Enter Room Number" value="' . htmlspecialchars($room_number) . '" maxlength="10" size ="10" autofocus="autofocus">';
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

$form = new RoomsForm();

include "/inc/forms.php";
?>