<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";
include "/inc/database.php";

class RacksForm implements formsInterface{
	public function isInputValid(){
		$name = $_POST['inputName'];
		$old_name = $_POST['inputOldName'];
		$room_id = $_POST['inputRoomID'];
		$floor_location = $_POST['inputFloorLocation'];
		$height = $_POST['inputHeight'];
		$width_id = $_POST['inputWidthID'];
		$depth_id = $_POST['inputDepthID'];
		$max_power = $_POST['inputMaxPower'];
		$comment = $_POST['inputComment'];

		if (empty($_POST['inputName'])) {
			return "Please input a name";
		}

		if (empty($_POST['inputRoomID'])) {
			return "Please choose a room number";
		}

		if (empty($_POST['inputHeight'])) {
			return "Please choose a height";
		}

		if (empty($_POST['inputWidthID'])) {
			return "Please select a width";
		}

		if (empty($_POST['inputDepthID'])) {
			return "Please select a depth";
		}

		if (empty($_POST['inputMaxPower'])) {
			return "Please input a max power";
		}

		return true;
	}

	public function submit(){
		global $pdo;

		$query = "INSERT INTO racks (name, old_name, room_id, floor_location, height_ru, width_id, depth_id, max_power, comment) Values
		(:name, :old_name, :room_id, :floor_location, :height, :width_id, :depth_id, :max_power, :comment)";

		$q = $pdo->prepare($query);
		$wasSuccessful = $q->execute(array(':name'=>$_POST['inputName'],
						  ':old_name'=>$_POST['inputOldName'],
						  ':room_id'=>$_POST['inputRoomID'],
						  ':floor_location'=>$_POST['inputFloorLocation'],
						  ':height'=>$_POST['inputHeight'],
						  ':width_id'=>$_POST['inputWidthID'],
						  ':depth_id'=>$_POST['inputDepthID'],
						  ':max_power'=>$_POST['inputMaxPower'],
						  ':comment'=>$_POST['inputComment']));

		if($wasSuccessful) {
			header("Location: /reports/racks.php?id=" . $pdo->lastInsertId());
			exit;
		} else {
			return "Insertion was Unsuccessful: Error code is " . $q->errorCode();
		}
	}

	public function getTitle(){
		return 'Racks';
	}

	public function getHeading(){
		return 'Racks';
	}

	public function getFormString(){
		$name = $_POST['inputName'];
		$old_name = $_POST['inputOldName'];
		$room_id = $_POST['inputRoomID'];
		$floor_location = $_POST['inputFloorLocation'];
		$height = $_POST['inputHeight'];
		$width_id = $_POST['inputWidthID'];
		$depth_id = $_POST['inputDepthID'];
		$max_power = $_POST['inputMaxPower'];
		$comment = $_POST['inputComment'];

		$string .= '<form role="form" method="post" action="' . $_SERVER['PHP_SELF'] . '">';

		$string .= '<div class="form-group">';
		$string .= '<label for="inputName">Name</label>';
		$string .= '<input type="text" name="inputName" class="form-control" id="inputName" placeholder="Enter Name" value="' . htmlspecialchars($name) . '" maxlength="15" size="15" autofocus="autofocus">';
		$string .= '</div>';

		$string .= '<div class="form-group">';
		$string .= '<label for="inputOldName">Old Name (Optional)</label>';
		$string .= '<input type="text" name="inputOldName" class="form-control" id="inputOldName" placeholder="Enter Old Name" value="' . htmlspecialchars($old_name) . '" maxlength="15" size ="15">';
		$string .= '</div>';

		$string .= '<div class="form-group">';
		$string .= '<label for="inputRoomID">Room Number</label>';
		$string .= '<select name="inputRoomID" class="form-control">';
		$string .= getRoomOptions($room_id);
		$string .= '</select>';
		$string .= '</div>';

		$string .= '<div class="form-group">';
		$string .= '<label for="inputFloorLocation">Floor Location</label>';
		$string .= '<input type="text" name="inputFloorLocation" class="form-control" id="inputFloorLocation" placeholder="Enter Floor Location" value="' . htmlspecialchars($floor_location) . '" maxlength="10" size ="10">';
		$string .= '</div>';

		$string .= '<div class="form-group">';
		$string .= '<label for="inputHeight">Height (ru)</label>';
		$string .= '<input type="text" name="inputHeight" class="form-control" id="inputHeight" placeholder="Enter Height" value="' . htmlspecialchars($height) . '" maxlength="10" size ="10">';
		$string .= '</div>';

		$string .= '<div class="form-group">';
		$string .= '<label for="inputWidthID">Width (inches)</label>';
		$string .= '<select name="inputWidthID" class="form-control">';
		$string .= getWidthOptions($width_id);
		$string .= '</select>';
		$string .= '</div>';

		$string .= '<div class="form-group">';
		$string .= '<label for="inputDepthID">Depth (inches)</label>';
		$string .= '<select name="inputDepthID" class="form-control">';
		$string .= getDepthOptions($depth_id);
		$string .= '</select>';
		$string .= '</div>';

		$string .= '<div class="form-group">';
		$string .= '<label for="inputMaxPower">Max Power</label>';
		$string .= '<input type="text" name="inputMaxPower" class="form-control" id="inputMaxPower" placeholder="Enter Max Power" value="' . htmlspecialchars($max_power) . '" maxlength="10" size ="10">';
		$string .= '</div>';

		$string .= '<div class="form-group">';
		$string .= '<label for="inputComment">Comments</label>';
		$string .= '<!--<input type="text" class="form-control" id="inputComment" placeholder="Enter Comments" maxlength="255" size ="255">-->';
		$string .= '<textarea name="inputComment" class="form-control" id="inputComment" placeholder="Enter Optional Comments" cols="60" rows="4">' . stripslashes($comment) . '</textarea>';
		$string .= '</div>';

		$string .= '<button type="submit" class="btn btn-default">Insert</button>';

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

$form = new RacksForm();

include "/inc/forms.php";
?>