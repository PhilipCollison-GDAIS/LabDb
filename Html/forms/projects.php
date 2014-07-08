<?php
	require_once "/inc/connect.php";
	global $pdo;

	if(isset($_POST['insert'])){
		$name = $_POST['inputProjectName'];
		$comment = $_POST['inputComment'];

		$query = "INSERT INTO projects (name, comment) Values (:name, :comment)";

		$q = $pdo->prepare($query);

		$wasSuccessful = $q->execute(array(':name'=>$name, ':comment'=>$comment));

		if($wasSuccessful){
			header('Location: /reports/projects.php?id=' . $pdo->lastInsertId());
			exit;
		} else {
			//TODO: Let the user fix input
		}
	}
 ?>
<!DOCTYPE html>
<html lang="en">
	<head>
	    <?php include "/inc/header.php" ?>

		<title>Projects</title>
	</head>

	<body>
		<div class="container">

			<?php include "/inc/navbar.php" ?>

			<div class="row">
				<?php include "/inc/sidebar.php" ?>

				<div class="col-md-10">
					<div class="jumbotron">

						<h1>Projects</h1>

						<form role="form" method="post" action="/forms/projects.php?submit">
							<div class="form-group">
								<label for="inputProjectName">Project Name</label>
								<input type="text" name="inputProjectName" class="form-control" id="inputProjectName" placeholder="Enter Project Name" value="<?php if(isset($name)){ echo htmlspecialchars($name);} ?>" maxlength="45" size ="45" autofocus="autofocus">
							</div>
							<div class="form-group">
								<label for="inputComment">Comments</label>
								<textarea name="inputComment" class="form-control" id="inputComment" placeholder="Enter Optional Comments"  cols="60" rows="4"><?php if(isset($comment)){ echo stripslashes($comment);} ?></textarea>
							</div>
							<button type="submit" name="insert" class="btn btn-default">Insert</button>
						</form>
					</div> <!--jumbotron-->
				</div>
				<div class="col-md-4"></div>
			</div>

		</div> <!-- /container -->

		<?php include "/inc/footer.php" ?>

	</body>
</html>