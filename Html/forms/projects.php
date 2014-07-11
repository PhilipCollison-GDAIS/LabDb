<?php
require_once "/inc/connect.php";
include "/inc/prototypes.php";

class ProjectsForm implements formsInterface{
	public function submit(){
		global $pdo;

		$name = $_POST['inputProjectName'];
		$comment = $_POST['inputComment'];

		if(isset($_POST['insert']) /* && inputValidation */) {
			$query = "INSERT INTO projects (name, comment) Values (:name, :comment)";

			$wasSuccessful = $pdo->prepare($query)->execute(array(':name'=>$name, ':comment'=>$comment));

			if ($wasSuccessful) {
				header('Location: /reports/projects.php?id=' . $pdo->lastInsertId());
				exit;
			} else {
				// TODO: inform user
			}
		}
	}

	public function getTitle(){
		return 'Projects';
	}

	public function getHeading(){
		return 'Projects';
	}

	public function getFormString(){
		$name = $_POST['inputProjectName'];
		$comment = $_POST['inputComment'];

		$string = '<form role="form" method="post" action="' . $_SERVER['PHP_SELF'] . '">';
		$string .= '<div class="form-group">';
		$string .= '<label for="inputProjectName">Project Name</label>';
		$string .= '<input type="text" name="inputProjectName" class="form-control" id="inputProjectName" placeholder="Enter Project Name" value="' . htmlspecialchars($name) . '" maxlength="45" size ="45" autofocus="autofocus">';
		$string .= '</div>';
		$string .= '<div class="form-group">';
		$string .= '<label for="inputComment">Comments</label>';
		$string .= '<textarea name="inputComment" class="form-control" id="inputComment" placeholder="Enter Optional Comments"  cols="60" rows="4">' . stripslashes($comment) . '</textarea>';
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

$form = new ProjectsForm();

include "/inc/forms.php";
?>