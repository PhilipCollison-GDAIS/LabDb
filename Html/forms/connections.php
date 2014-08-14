<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";
include "/inc/database.php";

class ConnectionForm implements formsInterface{
	public function isInputValid(){
		// TODO:

		return true;
	}

	public function submit(){
		global $pdo;

		try{
			// Insert connection
			$query = "INSERT INTO connections (port_id_1, port_id_2, comment) VALUES
			(:port_id_1, :port_id_2, :comment)";

			$q = $pdo->prepare($query);
			$wasSuccessful = $q->execute(array(':port_id_1'=>$_POST['port_id_1'],
							  ':port_id_2'=>$_POST['port_id_2'],
							  ':comment'=>$_POST['comment']));

			if ($wasSuccessful) {
				//Insertion of connection was successful

				// Find and store lastInsertId
				$lastInsertId = $pdo->lastInsertId();

				if (isset($_POST['project_id']) && !empty($_POST['project_id'])) {
					// Insert into project_connections connection with lastInsertId as id/pk
					$query = "INSERT INTO project_connections (connection_id, project_id) VALUES
					(:connection_id, :project_id)";

					$q = $pdo->prepare($query);
					$wasSuccessful = $q->execute(array(':connection_id'=>$lastInsertId,
									  ':project_id'=>$_POST['project_id']));
				}

				if($wasSuccessful){
					// All was successful and redirect user
					header('Location: /reports/connections.php?id=' . $lastInsertId);
					echo $lastInsertId;
					exit;
				} else {
					echo '<pre>';
					echo 'Insertion into project_connections was NOT successful' . "\n";
					echo ' . ^ . ^ .' . "\n";
					print_r($q->errorInfo()) . "\n";
					echo ' . ^ . ^ .' . "\n";
					echo $q->errorCode() . "\n";
					echo ' . ^ . ^ .' . "\n";
					echo '</pre>';
				}
			} else {
				echo '<pre>';
				echo 'Insertion of connection was NOT successful' . "\n";
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

	public function getTitle(){
		return 'Connection';
	}

	public function getHeading(){
		return 'Connection';
	}

	public function getFormString(){
		$string .= '<script type="text/javascript" src="/inc/port_select_for_connections/java.js"></script>';

		$string .= '<div class="row" style="margin-bottom: 25px;">';

		$port_label = "Port 1";
		$port_id = "port_id_1";
		$port_name = "port_id_1";
		$rack_label = "Rack 1";
		$rack_id = "rack_id_1";
		$rack_name = "rack_id_1";
		$equipment_label = "Equipment 1";
		$equipment_id = "equipment_id_1";
		$equipment_name = "equipment_id_1";

		ob_start();
		include "/inc/port_select_for_connections/main_body.php";
		$string .= trim(ob_get_clean());

		$port_label = "Port 2";
		$port_id = "port_id_2";
		$port_name = "port_id_2";
		$rack_label = "Rack 2";
		$rack_id = "rack_id_2";
		$rack_name = "rack_id_2";
		$equipment_label = "Equipment 2";
		$equipment_id = "equipment_id_2";
		$equipment_name = "equipment_id_2";

		ob_start();
		include "/inc/port_select_for_connections/main_body.php";
		$string .= trim(ob_get_clean());

		$string .= '</div>';

		$string .= '<div style="text-align:center">';
		$string .= '<button class="btn btn-default btn-lg create-connection-button" disabled="disabled" style="margin:0 auto;" onclick="createConnection();">Create Connection</button>';
		$string .= '</div>';

		$string .= '<div class="update"></div>';

		// $string .= '<div class="form-group">';
		// $string .= '<label for="project_id">Project (Optional)</label>';
		// 	$string .= '<select name="project_id" class="form-control">';
		// 		$string .= getProjectOptions($_POST['input_project_id']);
		// 	$string .= '</select>';
		// $string .= '</div>';

		// $string .= '<div class="form-group">';
		// 	$string .= '<label for="coment">Comments</label>';
		// 	$string .= '<textarea name="comment" class="form-control" id="inputComment" placeholder="Enter Optional Comments" cols="60" rows="0">' . stripslashes($comment) . '</textarea>';
		// $string .= '</div>';

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

$form = new ConnectionForm();

include "/inc/forms.php";
