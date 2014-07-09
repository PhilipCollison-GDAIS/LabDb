<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";
include "/inc/database.php";

class RacksForm implements formsInterface{
	public function submit(){
		global $pdo;

		$name = $_POST['inputName'];
		$old_name = $_POST['inputOldName'];
		$room_id = $_POST['inputRoomID'];
		$floor_location = $_POST['inputFloorLocation'];
		$height = $_POST['inputHeight'];
		$width_id = $_POST['inputWidthID'];
		$depth_id =  $_POST['inputDepthID'];
		$max_power =  $_POST['inputMaxPower'];
		$comment = $_POST['inputComment'];

		if(isset($_POST['insert']) /* && inputValidation */) {
			$query = "INSERT INTO racks (name, old_name, room_id, floor_location, height_ru, width_id, depth_id, max_power, comment) Values
			(:name, :old_name, :room_id, :floor_location, :height, :width_id, :depth_id, :max_power, :comment)";

			$q = $pdo->prepare($query);
			$wasSuccessful = $q->execute(array(':name'=>$name,
							  ':old_name'=>$old_name,
							  ':room_id'=>$room_id,
							  ':floor_location'=>$floor_location,
							  ':height'=>$height,
							  ':width_id'=>$width_id,
							  ':depth_id'=>$depth_id,
							  ':max_power'=>$max_power,
							  ':comment'=>$comment));

			if($wasSuccessful) {
				header("Location: /reports/racks.php?id=" . $pdo->lastInsertId());
				exit;
			} else {
				// TODO: Alert user of error
			}
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
		$depth_id =  $_POST['inputDepthID'];
		$max_power =  $_POST['inputMaxPower'];
		$comment = $_POST['inputComment'];

		$string .= '<form role="form" method="post" action="' . $_SERVER['PHP_SELF'] . '">';
		$string .= '<div class="form-group">';
		$string .= '<label for="inputName">Name</label>';
		$string .= '<input type="text" name="inputName" class="form-control" id="inputName" placeholder="Enter Name" value="' . htmlspecialchars($name) . '" maxlength="15" size="15" autofocus="autofocus">';
		$string .= '</div>';
		$string .= '<div class="form-group">';
		$string .= '<label for="inputOldName">Old Name</label>';
		$string .= '<input type="text" name="inputOldName" class="form-control" id="inputOldName" placeholder="Enter Old Name" value="' . htmlspecialchars($old_name) . '" maxlength="15" size ="15">';
		$string .= '</div>';
		$string .= '<div class="form-group">';
		$string .= '<label for="inputRoomID">Room Number</label>';
		$string .= '<select name="inputRoomID" class="form-control DropdownInitiallyBlank">';
		$string .= getRoomOptions($room_id);
		$string .= '</select>';
		$string .= '</div>';
		$string .= '<div class="form-group">';
		$string .= '<label for="inputFloorLocation">Floor Location</label>';
		$string .= '<input type="text" name="inputFloorLocation" class="form-control" id="inputFloorLocation" placeholder="Enter Floor Location" value="' . htmlspecialchars($floor_location) . '" maxlength="10" size ="10">';
		$string .= '</div>';
		$string .= '<div class="form-group">';
		$string .= '<label for="inputHeight">Height (ru)</label>';
		$string .= '<input type="text" name="inputHeight" class="form-control" id="inputHeight" placeholder="Enter Height" value="' . htmlspecialchars($height_ru) . '" maxlength="10" size ="10">';
		$string .= '</div>';
		$string .= '<div class="form-group">';
		$string .= '<label for="inputWidthID">Width</label>';
		$string .= '<select name="inputWidthID" class="form-control DropdownInitiallyBlank">';
		$string .= getWidthOptions($width_id);
		$string .= '</select>';
		$string .= '</div>';
		$string .= '<div class="form-group">';
		$string .= '<label for="inputDepthID">Depth</label>';
		$string .= '<select name="inputDepthID" class="form-control DropdownInitiallyBlank">';
		$string .= getDepthOptions($depth_id);
		$string .= '</select>';
		$string .= '</div>';
		$string .= '<div class="form-group">';
		$string .= '<label for="inputmax_power">max_power</label>';
		$string .= '<input type="text" name="inputMaxPower" class="form-control" id="inputMaxPower" placeholder="Enter Max Power" value="' . htmlspecialchars($max_power) . '" maxlength="10" size ="10">';
		$string .= '</div>';
		$string .= '<div class="form-group">';
		$string .= '<label for="inputComment">Comments</label>';
		$string .= '<!--<input type="text" class="form-control" id="inputComment" placeholder="Enter Comments" maxlength="255" size ="255">-->';
		$string .= '<textarea name="inputComment" class="form-control" id="inputComment" placeholder="Enter Optional Comments" cols="60" rows="4">' . stripslashes($comment) . '</textarea>';
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

$form = new RacksForm();

include "/inc/forms.php";
?>